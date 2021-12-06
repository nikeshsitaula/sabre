<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
    <div class="navbar-brand" style="padding-top: 10px; padding-bottom: 0px;">
        <a href="/admin/dashboard" class="d-inline-block">
            <img src="{{asset("img/frontend/sabre-logo-slab.svg")}}" alt="Sabre" style="height: 3rem;">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-md-auto">
            {{--<li class="nav-item dropdown">--}}
                {{--<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">--}}
                    {{--<i class="icon-bell3 mr-2"></i>--}}
                    {{--Notifications--}}
                {{--</a>--}}

                {{--<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">--}}
                    {{--<div class="dropdown-content-header">--}}
                        {{--<span class="font-size-sm line-height-sm text-uppercase font-weight-semibold">Latest activity</span>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-body dropdown-scrollable">--}}
                        {{--<ul class="media-list">--}}
                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<a href="#" class="btn bg-success-400 rounded-round btn-icon"><i--}}
                                                {{--class="icon-mention"></i></a>--}}
                                {{--</div>--}}

                                {{--<div class="media-body">--}}
                                    {{--<a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"--}}
                                    {{--<div class="font-size-sm text-muted mt-1">4 minutes ago</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-footer bg-light">--}}
                        {{--<a href="#"--}}
                           {{--class="font-size-sm line-height-sm text-uppercase font-weight-semibold text-grey mr-auto">All--}}
                            {{--activity</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}

            <li class="nav-item">
                <a href="{{route('frontend.auth.logout')}}" class="navbar-nav-link">
                    <i class="icon-switch2"></i>
                    <span class="d-md-none ml-2">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
