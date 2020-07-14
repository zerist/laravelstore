@extends('layouts.app')

@section('title', 'topics')

@section('content')
    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 topic-list">
            <div class="card border-light">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Last Reply</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Last Updated</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    {{--topics list--}}
                    @include('topics._topic_list', ['topics' => $topics])

                    <br/>
                    {{ $topics->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>
@endsection
