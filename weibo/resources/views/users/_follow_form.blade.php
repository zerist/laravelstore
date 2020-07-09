@can('follow', $user)
    <div class="text-center mt-2 mb-4">
        @if (Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-sm btn-outline-primary">unfollow</button>
            </form>
        @else
            <form action="{{ route('followers.store', $user->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">follow</button>
            </form>
        @endif
    </div>
@endcan
