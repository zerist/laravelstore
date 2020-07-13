@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <h4>
                        <ion-icon name="create-outline"></ion-icon> 编辑个人资料
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @include('shared._error')
                        <div class="form-group">
                            <label for="name-field">用户名</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" />
                        </div>
                        <div class="form-group">
                            <label for="email-field">邮 箱</label>
                            <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" />
                        </div>
                        <div class="form-group">
                            <label for="introduction-field">个人简介</label>
                            <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="" class="avatar-label">Image</label>
                            <input type="file" name="avatar" class="form-control-file">
                         </div>

                        @if($user->avatar)
                            <br>
                            <img class="img-thumbnail" src="{{ url($user->avatar) }}" alt="avatar" width="200px">
                        @endif

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
