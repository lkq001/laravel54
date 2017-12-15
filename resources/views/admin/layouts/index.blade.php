<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')
<body>

<!-- Aside Start-->
@include('admin.layouts.aside')
<!-- Aside Ends-->


<!--Main Content Start -->
<section class="content">

@include('admin.layouts.top')

<!-- Page Content Start -->
    <!-- ================== -->

    <div class="wraper container-fluid">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('page-title')</h3>
        </div>
        @yield('content')
    </div>
    <!-- Page Content Ends -->
    <!-- ================== -->

    <!-- Footer Start -->
        @include('admin.layouts.footer')
    <!-- Footer Ends -->


</section>
    @include('admin.layouts.script')
    @yield('script')
</body>
</html>
