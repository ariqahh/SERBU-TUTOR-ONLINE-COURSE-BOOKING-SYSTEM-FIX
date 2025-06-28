<!doctype html>
<html lang="en">
<!--begin::Head-->
@include('layouts.head')
<!--end::Head-->
<!--begin::Body-->

<body class="layouts-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('layouts.nav')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('layouts.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        @yield('content')
        <!--end::App Main-->
        <!--begin::Footer-->
        @include('layouts.footer')
        <!--end::Footer-->
    </div>

    @include('layouts.script')
    @stack('scripts')
</body>
<!--end::Body-->

</html>
