<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LaraBBS') - Laravel</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
@include('shared._message')
<div class="custom-file">
    <form class="form-control" method="post" action="{{ url('/excel/import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="testExcel" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
        <button type="submit" class="btn btn-primary">upload</button>
    </form>
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>

</html>
