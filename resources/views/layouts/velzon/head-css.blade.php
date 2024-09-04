

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Layout config Js -->
<script src="{{ URL::asset('build/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
{{-- @yield('css') --}}


@yield('css')
<style>
    .select2-container .select2-selection--single {
      height: 37.5px !important;
      border-color: #ced4da !important;
    }

    .paginate_button.current {
      margin-top: 10px !important;
      font-size: 10px !important;
      /* padding: 5px !important; */
      background-color: #f3f6f9 !important;
      border-color: #f3f6f9 !important;
      color: rgb(255, 255, 255) !important;
    }

    .badge{
      font-size: 10px !important;
    }

    td{
      color: rgb(110, 110, 110) !important;
    }

    thead{
      background-color: #f3f6f9 !important;
    }
    
    table{
      border: rgb(231, 231, 231) !important
    }

    .select2 {
      /* z-index: 2000; */
      position: relative !important;
    }

    .swal2-cancel  {
        margin-left: 10px;
    }
    .swal2-confirm  {
      margin-left: 10px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #4b38b3 !important;
    }

</style>