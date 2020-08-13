<?php
require '../vendor/autoload.php';
use \App\Handlers\SlugTranslateHandler;


class Foo
{
    private $name = 1;
    function getClosure($c)
    {
        $local = 1;
        return function ($a) use ($local, $c) {
            var_dump($local);
            var_dump($this);
            var_dump($c);
            var_dump(debug_backtrace());
            var_dump(get_defined_vars());
            //var_dump(get_defined_functions());
        };
    }

    public function getFunctions()
    {
        var_dump(get_defined_functions());
    }

}

$a = (new Foo())->getClosure('ss');
$a(11);

class Doo
{
    public $name = 'ss';
    public $map = [
        'ss' => 11
    ];

    public function setAge($name, $key)
    {
        return $this->map[$key] = $name;
    }

    public function getArgs($name)
    {
        var_dump(get_defined_vars());
    }

}
