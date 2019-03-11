@if (count($topics))
    <ul class="list-group">
        @foreach ($topics as $topic)
            <li class="list-group-item">
                <a href="{{ route('topics.show',$topic->id) }}">
                    {{ $topic->title }}
                </a>
                <span class="pull-right">
                    {{$topic->reply_count}}个回复
                    <span> · </span>
                    {{$topic->created_at->diffForHumans()}}
                </span>
            </li>
        @endforeach
    </ul>
@else
    <div class="empty-block">他还没发表过文章呢</div>
@endif

{!! $topics->render() !!}