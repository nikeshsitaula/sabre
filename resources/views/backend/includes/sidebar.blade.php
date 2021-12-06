<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">Notification</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="#">
                        <img src="{{ $logged_in_user->picture}}"
                             class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a>
                    <h6 class="mb-0 text-white text-shadow-dark">{{$logged_in_user->name}}</h6>
                    <span
                        class="font-size-sm text-white text-shadow-dark">{{strtoupper($logged_in_user->getRoleNames()[0])}}</span>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav"
                       class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle"
                       data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="{{url('account')}}" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>My profile</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/logout" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>


        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Main</div>
                    <i class="icon-menu" title="Main"></i></li>
                {{--<li class="nav-item">--}}
                {{--<a href="{{route('admin.dashboard')}}"--}}
                {{--class="nav-link {{active_class(Active::checkUriPattern('admin/dashboard'))}}">--}}
                {{--<i class="icon-home4"></i><span>Dashboard</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                @if ($logged_in_user->isAdmin())
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('admin/auth*'), 'nav-item-open')
                }}">
                        <a href="#" class="nav-link"><i class="icon-lock2"></i> <span>Access</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Access"
                            style="display: {{active_class(Active::checkUriPattern('admin/auth*'), 'block')}}; ">
                            <li class="nav-item"><a href="{{route('admin.auth.user.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('admin/auth/user'))}}"><i
                                        class="icon-users"></i>Users</a>
                            </li>
                            <li class="nav-item"><a href="{{route('admin.auth.role.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('admin/auth/role'))}}"><i
                                        class="icon-collaboration"></i>Roles</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--                <li class="nav-item"><a href="{{route('admin.dashboard')}}"--}}
                {{--                                        class="nav-link {{active_class(Active::checkUriPattern('admin/dashboard'))}}">--}}
                {{--                        <i class="icon-home4"></i><span>Landing Page</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}

                {{--Employee Sidebar--}}
                {{--                @if ($logged_in_user->isAdmin())--}}
                @if (auth()->user()->hasanyrole('administrator|employeemanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('employee'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-users2"></i> <span>Employee</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Employee"
                            style="display: {{active_class(Active::checkUriPattern('employee*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('dashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/dashboard'))}}">
                                    <i class="icon-home4"></i><span>Employee Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('employee.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee'))}}"><i
                                        class="icon-people"></i>Employee List</a>
                            </li>
                            <li class="nav-item"><a href="{{route('experience.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/experience'))}}"><i
                                        class="icon-pen"></i>Experience</a>
                            </li>
                            <li class="nav-item"><a href="{{route('career.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/career'))}}"><i
                                        class="icon-user-tie"></i>Career</a>
                            </li>
                            <li class="nav-item"><a href="{{route('education.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/education'))}}"><i
                                        class="icon-graduation"></i>Education</a>
                            </li>
                            <li class="nav-item"><a href="{{route('training.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/training'))}}"><i
                                        class="icon-mouse-left"></i>Training</a>
                            </li>
                            <li class="nav-item"><a href="{{route('document.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/document'))}}"><i
                                        class="icon-file-text3"></i>Document</a>
                            </li>
                            <li class="nav-item"><a href="{{route('miscz.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('employee/miscz'))}}"><i
                                        class="icon-file-plus2"></i>Miscellaneous</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--travel Agency Sidebar--}}
                @if (auth()->user()->hasanyrole('administrator|travelmanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('travel'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-direction"></i> <span>Travel</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Travel"
                            style="display: {{active_class(Active::checkUriPattern('travel*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('traveldashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/dashboard'))}}">
                                    <i class="icon-home4"></i><span>Travel Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('travel.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel'))}}">
                                    <i class="icon-office "></i>Travel Agency </a>
                            </li>
                            <li class="nav-item"><a href="{{route('pcc.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/pcc'))}}">
                                    <i class="icon-list "></i>PCC </a>
                            </li>
                            <li class="nav-item"><a href="{{route('staff.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/staff'))}}">
                                    <i class="icon-people"></i>Staff
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('trainingstaff.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/trainingstaff'))}}">
                                    <i class="icon-stack4"></i>Staff Training
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('lniata.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/lniata'))}}">
                                    <i class="icon-file-play2"></i>LNIATA
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('travelmiscz.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/miscz'))}}">
                                    <i class="icon-file-plus2 "></i>Miscellaneous
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('visit.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/visit'))}}">
                                    <i class=" icon-map5 "></i>Visit Manager
                                </a>
                            </li>
                            {{--                            <li class="nav-item"><a href="{{route('accountmanager.index')}}"--}}
                            {{--                                                    class="nav-link {{active_class(Active::checkUriPattern('travel/accountmanager'))}}">--}}
                            {{--                                    <i class=" icon-user-tie "></i>Account Manager--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>
                @endif

                {{--airlines Sidebar--}}

                @if (auth()->user()->hasanyrole('administrator|airlinemanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('airlines'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-airplane3"></i> <span>Airline</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Airlines"
                            style="display: {{active_class(Active::checkUriPattern('airlines*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('airlinesdashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('airlines/dashboard'))}}">
                                    <i class="icon-home4"></i><span>Airline Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('airlines.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('airlines'))}}">
                                    <i class="icon-paperplane"></i><span>Airlines</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('airlinesstaff.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('airlinesstaff/pcc'))}}">
                                    <i class="icon-people "></i><span>Staff</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('airlinesvisit.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('airlinesvisit/staff'))}}">
                                    <i class="icon-list"></i><span>Airlines Visit</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('airlinesmisc.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('airlinesmisc/misc'))}}">
                                    <i class="icon-file-plus2 "></i><span>Miscellaneous</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--Booking Sidebar--}}
                @if (auth()->user()->hasanyrole('administrator|bookingmanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('booking'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-bookmark"></i> <span>Bookings</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Booking"
                            style="display: {{active_class(Active::checkUriPattern('booking*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('booking.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('booking'))}}">
                                    <i class="icon-bookmarks"></i><span>MIDT</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('revenue.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('booking/revenue'))}}">
                                    <i class="icon-cash "></i><span>Revenue</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('incentive.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('booking/incentive'))}}">
                                    <i class="icon-percent"></i><span>Incentive</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--Accounts Sidebar--}}
                @if (auth()->user()->hasanyrole('administrator|accountmanagement'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('accounts'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-users4"></i> <span>Account Management</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Account"
                            style="display: {{active_class(Active::checkUriPattern('accounts*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('accountdashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('accounts/dashboard'))}}">
                                    <i class="icon-home4"></i><span>Account Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('accounts.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('accounts'))}}">
                                    <i class="icon-user"></i><span>Account Manager</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('agencyagreement.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('accounts/agencyagreement'))}}">
                                    <i class="icon-file-check"></i><span>Agency Agreement</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('incentivedata.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('accounts/incentivedata'))}}">
                                    <i class="icon-sort-time-asc"></i><span>Incentive Controller</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif


                {{--Products Sidebar--}}
                @if (auth()->user()->hasanyrole('administrator|productmanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('products'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-inbox-alt"></i> <span>Product</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Products"
                            style="display: {{active_class(Active::checkUriPattern('products*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('productdashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('products/productdashboard'))}}">
                                    <i class="icon-home4"></i><span>Product Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('products.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('products'))}}">
                                    <i class="icon-stack2"></i><span>Product Description</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('productsagreement.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('products/productsagreement'))}}">
                                    <i class="icon-typewriter"></i><span>Product Agreement</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('productscost.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('products/productscost'))}}">
                                    <i class="icon-coin-dollar"></i><span>Product Cost Details</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('productscostentry.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('products/productscostentry'))}}">
                                    <i class="icon-calculator3"></i><span>Product Cost Entry</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                {{--Sales Sidebar--}}
                @if (auth()->user()->hasanyrole('administrator|salesmanager'))
                    <li class="nav-item nav-item-submenu {{
                    active_class(Active::checkUriPattern('sales'), 'nav-item-open')}}">
                        <a href="#" class="nav-link"><i class="icon-stats-growth"></i>
                            <span>Sales & Marketing</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Sales"
                            style="display: {{active_class(Active::checkUriPattern('sales*'), 'block')}}; ">

                            <li class="nav-item"><a href="{{route('smadashboard.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('sales/smadashboard'))}}">
                                    <i class="icon-home4"></i><span>SMA Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{route('sales.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('sales'))}}">
                                    <i class="icon-chart"></i><span>SMA</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('smaprize.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('sales/smaprize'))}}">
                                    <i class="icon-pie-chart2"></i><span>SMA Prize</span>
                                </a>
                            </li>
                            <li class="nav-item"><a href="{{route('smaothercost.index')}}"
                                                    class="nav-link {{active_class(Active::checkUriPattern('sales/smaothercost'))}}">
                                    <i class="icon-coins"></i><span>SMA Other Cost</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
