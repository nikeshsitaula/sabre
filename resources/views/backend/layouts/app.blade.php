<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.includes.meta')
    @include('backend.includes.stylesheet')
    @include('backend.includes.javascripts')

</head>

<body>
@include('backend.includes.navbar')
<!-- Page content -->
<div class="page-content">
@include('backend.includes.sidebar')
<!-- Main content -->
    <div class="content-wrapper">
    @include('backend.includes.header')
    <!-- Content area -->
        <div class="content">
        @include('includes.partials.logged-in-as')
        <!-- Dashboard content -->
            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @include('includes.partials.messages')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /dashboard content -->
        </div>
        @stack('scripts')
        <!-- /content area -->
        @include('backend.includes.footer')
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->

</body>

</html>
