<?php
require '../vendor/autoload.php';

class Task
{
    protected $taskId;
    protected $coroutine;
    protected $sendValue = null;
    protected $beforeFirstYield = true;
    protected $parentTaskId;
    protected $childTaskIds = [];

    public function __construct($taskId, Generator $coroutine)
    {
        $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }

    public function getTaskId()
    {
        return $this->taskId;
    }

    public function getParentTaskId()
    {
        return $this->parentTaskId;
    }

    public function setParentTaskId($taskId)
    {
        $this->parentTaskId = $taskId;
    }

    public function getChildTaskIds()
    {
        return $this->childTaskIds;
    }

    public function addChildTaskId($taskId)
    {
        if (in_array($taskId, $this->childTaskIds)) {
            return false;
        }
        $this->childTaskIds[] = $taskId;
        return true;
    }

    public function removeChildTaskId($taskId)
    {
        if (!in_array($taskId, $this->childTaskIds)) {
            return false;
        }
        $pos = array_search($taskId, $this->childTaskIds);
        unset($this->childTaskIds[$pos]);

        return true;
    }

    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    public function run()
    {
        if ($this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        } else {
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
        }
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}


class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskMap = [];
    protected $taskQueue;
    protected $waitForRead = [];
    protected $waitForWrite = [];

    public function __construct()
    {
        $this->taskQueue = new SplQueue();
    }

    public function getTask($taskId)
    {
        return $this->taskMap[$taskId] ?: false;
    }

    public function newTask(Generator $coroutine)
    {
        $taskId = ++$this->maxTaskId;
        $task = new Task($taskId, $coroutine);
        $this->taskMap[$taskId] = $task;
        $this->schedule($task);
        return $taskId;
    }

    public function newChildTask(Generator $coroutine, $taskId)
    {
        $childTaskId = $this->newTask($coroutine);
        $childTask = $this->getTask($childTaskId);
        $childTask->setParentTaskId($taskId);

        $parentTask = $this->getTask($taskId);
        $parentTask->addChildTaskId($childTaskId);

        return $childTaskId;
    }

    public function killTask($taskId)
    {
        if (!isset($this->taskMap[$taskId])) {
            return false;
        }
        unset($this->taskMap[$taskId]);

        foreach ($this->taskQueue as $key => $task) {
            if ($taskId === $task->getTaskId()) {
                //update parent task
                $parentTaskId = $task->getParentTaskId();
                if ($parentTaskId > 0) {
                    $parentTask = $this->getTask($parentTaskId);
                    $parentTask->removeChildTaskId($taskId);
                }

                unset($this->taskQueue[$key]);
                break;
            }
        }

        return true;
    }

    public function killTaskWithChildTask($taskId)
    {
        //find all child tasks and kill
        $childTaskIds = $this->getTask($taskId)->getChildTaskIds();
        foreach ($childTaskIds as $childTaskId) {
            $this->killTask($childTaskId);
        }
        //kill self
        $this->killTask($taskId);
        return true;
    }

    public function waitForRead($socket, Task $task)
    {
        if (isset($this->waitForRead[(int) $socket])) {
            $this->waitForRead[(int) $socket][1][] = $task;
        } else {
            $this->waitForRead[(int) $socket] = [$socket, [$task]];
        }
    }

    public function waitForWrite($socket, Task $task)
    {
        if (isset($this->waitForWrite[(int) $socket])) {
            $this->waitForWrite[(int) $socket][1][] = $task;
        } else {
            $this->waitForWrite[(int) $socket] = [$socket, [$task]];
        }
    }

    protected function ioPoll($timeout)
    {
        $rSocks = [];
        foreach ($this->waitForRead as list($socket)) {
            $rSocks[] = $socket;
        }

        $wSocks = [];
        foreach ($this->waitForWrite as list($scoket)) {
            $wSocks[] = $socket;
        }

        $eSocks = [];
        if (!stream_select($rSocks, $wSocks, $eSocks, $timeout)) {
            return;
        }

        foreach ($rSocks as $socket) {
            list(, $tasks) = $this->waitForRead[(int) $socket];
            unset($this->waitForRead[(int) $socket]);
            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }

        foreach ($wSocks as $sock) {
            list(, $tasks) = $this->waitForWrite[(int) $scoket];
            unset($this->waitForWrite[(int) $scoket]);
            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }
    }

    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            $task = $this->taskQueue->dequeue();
            $retval = $task->run();
            if ($retval instanceof SystemCall) {
                $retval($task, $this);
                continue;
            }

            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }

}

class SystemCall
{
    protected $callback;
    public function __construct (callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Task $task, Scheduler $scheduler)
    {
        $callback = $this->callback;
        return $callback($task, $scheduler);
    }
}

function getTaskId()
{
    return new SystemCall(function (Task $task, Scheduler $scheduler) {
        $task->setSendValue($task->getTaskId());
        $scheduler->schedule($task);
    });
}


function newTask(Generator $coroutine)
{
    return new SystemCall(function (Task $task, Scheduler $scheduler) use ($coroutine) {
        $task->setSendValue($scheduler->newTask($coroutine));
        $scheduler->schedule($task);
    });
}

function killTask($taskId)
{
    return new SystemCall(function (Task $task, Scheduler $scheduler) use ($taskId) {
        $task->setSendValue($scheduler->killTaskWithChildTask($taskId));
        //$scheduler->schedule($task);
    });
}

function newChildTask(Generator $coroutine, $parentTaskId)
{
    return new SystemCall(function (Task $task, Scheduler $scheduler) use ($coroutine, $parentTaskId) {
        $task->setSendValue($scheduler->newChildTask($coroutine, $parentTaskId));
        $scheduler->schedule($task);
    });
}

function waitForRead($socket)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($socket) {
            $scheduler->waitForRead($socket, $task);
        }
    );
}

function waitForWrite($socket)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($socket) {
            $scheduler->waitForWrite($socket, $task);
        }
    );
}

function childTask()
{
    $taskId = (yield getTaskId());
    while (true) {
        echo "Child task $taskId still alive! \n";
        yield;
    }
}

function task()
{
    $taskId = (yield getTaskId());
    $childTaskId = (yield newChildTask(childTask(), $taskId));

    foreach (range(1, 6) as $num) {
        echo "Parent task $taskId iteration $num. \n";
        yield;
        ($num == 3) and (yield killTask($taskId));
    }
}

$scheduler = new Scheduler();
$scheduler->newTask(task());
$scheduler->run();
