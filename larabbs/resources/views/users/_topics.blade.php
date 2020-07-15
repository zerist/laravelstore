@if (count($topics))
    <div class="tab-content">
        <div class="tab-pane active" id="topics">
            <ul class="list-group mt-4 border-0">
                @foreach($topics as $topic)
                    <li class="list-group-item pl-2 pr-2 border-right-0 border-left-0 @if($loop->first) border-top-0 @endif">
                        <a class="nav-link" href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a>
                        <span class="float-right text-secondary">
                            {{ $topic->reply_count }} Reply
                            <span> | </span>
                            {{ $topic->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-pane" id="replies">
            <p>Todo</p>
        </div>
    </div>
@else
    <div class="empty">
        No Data ...
    </div>
@endif
<div class="mt-4 pt-1">
    {{ $topics->links() }}
</div>
