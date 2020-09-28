<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{!!  csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>La Finca</title>
    <!-- css: vendors -->
    <link rel="stylesheet" href="{!!asset('css/materialdesignicons.css')!!}">
    <link rel="stylesheet" href="{!!asset('css/app.css')!!}">
    <link rel="stylesheet" href="{!!asset('css/style.css')!!}">

    <!-- css: DataTable library -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.css"/>
    {{--     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/r-2.2.2/datatables.min.css"/> --}}
    <!-- css:custom page -->
    @yield('css')
</head>

<body>
    <div class="container-scroller">
        <!-- navbar -->
        {{-- @include('layouts.navbar') --}}
        <!-- navbar ends -->
        <!-- page-body-wrapper -->
        {{-- <div class="container-fluid page-body-wrapper"> --}}
            <!-- sidebar -->
            {{-- @include('layouts.sidebar') --}}
            <!-- sidebar ends -->
            <!-- main panel -->
            {{-- <div class="main-panel"> --}}
                <!-- main content -->
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-start mt-1">
                            <span class="badge badge-outline-success badge-button">
                                Importador La Finca
                            </span>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <a class="badge badge-outline-primary badge-button mr-5" href="/">
                                Importación
                            </a>
                            <a class="badge badge-outline-success badge-button mr-5" href="/variants">
                                Gestionar Variantes
                            </a>
                            <a class="badge badge-outline-success badge-button mr-5" href="/categories">
                                Gestionar Categorias
                            </a>
                            <a class="badge badge-outline-primary badge-button mr-5" href="/products">
                                Gestionar Productos
                            </a>
                            <a class="badge badge-outline-primary badge-button mr-5" href="/export">
                                Exportación
                            </a>
                        </div>
                        @yield('content')
                    </div>
                </div>
                <!-- main content ends -->
                <!-- footer -->
                {{-- @include('layouts.footer') --}}
                <!-- footer ends -->
            {{-- </div> --}}
            <!-- main panel ends -->
        {{-- </div> --}}
        <!-- page-body-wrapper ends -->
    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.js"></script>
    <!-- js: vendors -->
    {{-- <script src="{!!asset('vendors/js/vendor.bundle.base.js')!!}"></script> --}}
    {{-- <script src="{!!asset('vendors/js/vendor.bundle.addons.js')!!}"></script> --}}
    <!-- js: injected -->
    {{-- <script src="{!!asset('js/off-canvas.js')!!}"></script> --}}
    {{-- <script src="{!!asset('js/misc.js')!!}"></script> --}}
    {{--     <script src="{!!asset('js/dashboard.js')!!}"></script> --}}
    <!-- jQuery -->{{-- 
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
    </script> --}}
    <!-- jQuery modal library -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script> --}}
    <!-- jQuery UI library -->
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    {{-- <script src="{!!asset('js/jquery.ui.touch-punch.js') !!}"></script> --}}
    <!-- DataTable library -->
{{--     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/r-2.2.2/datatables.min.js"></script> --}}
    <!-- Custom scripts -->
    @yield('body_scripts')
</body>

@yield('script')

{{-- Global configs --}}
<script>
    //Overlays, modals config
    $(document).ready(function(){
        // $('#flash-overlay-modal').modal();
        $('div.alert:not(.static)').delay(2500).slideUp("slow");
    });
    //GoBack Button config
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = document.referrer;
            //or location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }
</script>

</html>
