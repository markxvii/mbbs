<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{route('topics.create')}}" class="btn btn-success btn-block">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp;有什么新想法？
        </a>
    </div>
</div>

@if (isset($links))
    <div class="panel panel-default">
        <div class="panel-body active-users">
            <div class="text-center">友情链接</div>
            <hr>
            @foreach ($links as $link)
                <a href="{{$link->link}}" class="media">
                    <div class="media-body">
                        <span class="media-heading">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

@if (isset($active_users))
    <div class="panel panel-default">
        <div class="panel-body active-users">

            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($active_users as $active_user)
                <a class="media" href="{{ route('users.show', $active_user->id) }}">
                    <div class="media-left media-middle">
                        <img src="{{ $active_user->avatar }}" width="24px" height="24px" class="img-circle media-object">
                    </div>

                    <div class="media-body">
                        <span class="media-heading">{{ $active_user->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif