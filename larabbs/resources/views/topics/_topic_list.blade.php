@if(count($topics))
    <ul class="list-group">
        @foreach($topics as $topic)
            <li class="list-group-item">
                <div class="card mb-3 border-light">
                    <div class="row no-gutters">
                        <div class="col-md-2">
                            <a href="{{ route('users.show', $topic->user_id) }}">
                                <img src="{{ $topic->user->avatar }}" class="card-img" alt="{{ $topic->name }}" title="{{ $topic->user->name }}">
                            </a>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('topics.index', [$topic->id]) }}" title="{{ $topic->title }}">
                                        {{ $topic->title }}
                                        <p class="text-right d-inline float-right">
                                            <span class="badge badge-pill badge-secondary">{{ $topic->reply_count }}</span>
                                        </p>
                                    </a>
                                </h5>
                                <nav class="card-text">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <p>
                                                <a class="text-secondary" href="{{ route('categories.show', $topic->category_id) }}" title="{{ $topic->category->name }}">
                                                    <ion-icon name="pricetag-outline"></ion-icon>
                                                    {{ $topic->category->name }}
                                                </a>
                                            </p>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <p>
                                                <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}">
                                                    <ion-icon name="person-circle-outline"></ion-icon>
                                                    {{ $topic->user->name }}
                                                </a>
                                            </p>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <p>
                                                <ion-icon name="time-outline"></ion-icon>
                                                <span class="text-muted">Last Updated at: {{ $topic->updated_at->diffForHumans() }}</span>
                                            </p>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach
    </ul>
@else
    <div class="text-info">No Data ...</div>
@endif
