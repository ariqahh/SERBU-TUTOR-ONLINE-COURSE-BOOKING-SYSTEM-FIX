<!doctype html>
<html lang="en">
  <!--begin::Head-->
 @include('layout.head')
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
     @include('layout.nav')
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include('layout.sidebar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
        @yield('content')
      <!--end::App Main-->
      <!--begin::Footer-->
     @include('layout.footer')
      <!--end::Footer-->
    </div>

 @include('layout.script')
  </body>
  <!--end::Body-->
</html>
