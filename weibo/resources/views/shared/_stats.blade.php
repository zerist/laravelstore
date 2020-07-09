<a href="#">
    <strong id="following" class="stat">
        {{ count($user->followings) }}
    </strong>
    followings
</a>
<a href="#">
    <strong id="followers" class="stat">
        {{ count($user->followers) }}
    </strong>
    followers
</a>
<a href="#">
    <strong id="statuses" class="stat">
        {{ $user->statuses()->count() }}
    </strong>
    Weibo
</a>
