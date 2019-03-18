<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                MBBS
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a>
                </li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}"><a
                            href="{{ route('categories.show', 1) }}">PHP</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 2))) }}"><a
                            href="{{ route('categories.show', 2) }}">音乐</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 3))) }}"><a
                            href="{{ route('categories.show', 3) }}">穿搭</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 4))) }}"><a
                            href="{{ route('categories.show', 4) }}">好书</a></li>
            </ul>
            <form class="navbar-form navbar-left" action="{{ route('topics.index') }}">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="搜索帖子、分类或人" name="search">
                </div>
            </form>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    <li>
                        <a href="{{route('topics.create')}}">
                            <span class="glyphicon glyphicon-send"></span>
                        </a>
                    </li>

                {{--未读消息通知--}}
                <li>
                    <a href="{{route('notifications.index')}}" class="notifications-badge" style="margin-top: -2px;">
                        <span class="badge badge-{{ Auth::user()->notification_count >0 ? 'hint' : 'fade' }}" title="消息提醒">
                            {{ Auth::user()->notification_count }}
                        </span>
                    </a>
                </li>
                {{--未读消息通知--}}

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img @if (Auth::user()->avatar)
                                     src="{{ Auth::user()->avatar }}"
                                     @else
                                     src="https://iocaffcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60"
                                     @endif
                                     class="img-responsive img-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if (!Auth::user()->email_verified)
                                <li>
                                <a href="{{ route('send_email_verification') }}">
                                    验证邮箱
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('users.show',Auth::id()) }}">
                                    个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.edit',Auth::id()) }}">编辑资料</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    退出登录
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>