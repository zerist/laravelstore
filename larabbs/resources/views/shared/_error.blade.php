@if (count($errors) > 0)
    <div class="alert alert-danger">
        <div class="mt-2"><b>Something Errod: </b></div>
        <ul class="mt-2 mb-2">
            @foreach($errors->all() as $error)
                <li><i class="glyphicon glyohicon-remove"> {{ $error }}</i> </li>
            @endforeach
        </ul>
    </div>
@endif
