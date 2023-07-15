<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ \Osiset\ShopifyApp\getShopifyConfig('app_name') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/css/daterangepicker.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('public/css/icheck-bootstrap.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/buttons.bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('public/css/bootstrap-duallistbox.min.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('public/css/summernote-bs4.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('public/css/bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
  @yield('styles')
</head>

<body>
  <div class="app-wrapper">
    <div class="app-content">
      <main role="main">
        <div class="wrapper">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  @if (\Osiset\ShopifyApp\getShopifyConfig('appbridge_enabled'))
    <script
            src="https://unpkg.com/@shopify/app-bridge{{ \Osiset\ShopifyApp\getShopifyConfig('appbridge_version') ? '@' . config('shopify-app.appbridge_version') : '' }}">
    </script>
    <script>
      var AppBridge = window['app-bridge'];
      var createApp = AppBridge.default;
      var app = createApp({
        apiKey: '{{ \Osiset\ShopifyApp\getShopifyConfig('api_key', Auth::user()->name) }}',
        shopOrigin: '{{ Auth::user()->name }}',
        forceRedirect: true,
      });

    </script>

    @include('shopify-app::partials.flash_messages')
  @endif


  <!-- jQuery -->
  <script src="{{ asset('public/js/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('public/js/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)

  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('public/js/select2.full.min.js') }}"></script>
  <!-- jquery-validation -->
  <script src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('public/js/additional-methods.min.js') }}"></script>
  <!-- InputMask -->
  <script src="{{ asset('public/js/moment.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('public/js/daterangepicker.js') }}"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('public/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('public/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('public/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('public/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('public/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('public/js/jszip.min.js') }}"></script>
  <script src="{{ asset('public/js/pdfmake.min.js') }}"></script>
  <script src="{{ asset('public/js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('public/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('public/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('public/js/buttons.colVis.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('public/js/adminlte.min.js') }}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('public/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('public/js/summernote-bs4.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('public/js/sweetalert2.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('public/js/demo.js') }}"></script>
  <script src="{{ asset('public/js/common.js') }}?v=5.9.5"></script>

  @yield('scripts')
</body>

</html>
