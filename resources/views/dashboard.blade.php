@extends('layouts.app')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">
                <!-- Welcome card -->
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-1">Welcome {{ Auth::user()->name }}! 🎉</h4>
                            <p class="pb-0">{{ Auth::user()->role == 1 ? 'System Admin' : (Auth::user()->role == 2 ? 'Admin' : 'User') }}</p>
                        </div>
                        <img
                            src="../assets/img/icons/misc/triangle-light.png"
                            class="scaleX-n1-rtl position-absolute bottom-0 end-0"
                            width="166"
                            alt="triangle background"
                            data-app-light-img="icons/misc/triangle-light.png"
                            data-app-dark-img="icons/misc/triangle-dark.png" />
                    </div>
                </div>
                <!--/ Welcome card -->

                <!-- col-lg-8 -->
                <div class="col-lg-8"></div>
                <!--/ col-lg-8 -->
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        @include('__partials__.admin.footer')
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
