@include('__partials__.admin.header')


<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Menu -->
        @include('__partials__.admin.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('__partials__.admin.navbar')
            <!-- / Navbar -->


            <div class="content-wrapper">
            <!-- Alert message -->
            @include('__partials__.admin.session_msg')
            <!-- Alert message -->

            <!-- Content wrapper -->
            @yield('admin_content')
            <!-- Content wrapper -->
            </div>
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
@include('__partials__.admin.bottom_footer')
