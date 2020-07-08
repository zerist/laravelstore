<form action="{{ route('statuses.store') }}" method="POST">
    @include('shared._errors')
    @csrf
        <textarea class="form-control" rows="3" placeholder="Write here ..." name="content">{{ old('content') }}</textarea>
    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">Commit</button>
    </div>
</form>
