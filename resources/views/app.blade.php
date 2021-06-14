<!DOCTYPE html>
<html lang="{!! app()->getLocale() !!}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>La Finca</title>
    <!-- css: vendors -->
    <link rel="stylesheet" href="{!! asset('css/materialdesignicons.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">

    <!-- css: DataTable library -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.css" />
        <style>
            a:hover{
                text-decoration: none;
            }
        </style>
    @yield('css')
</head>

<body>
    <div class="container-scroller">
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
                    <a class="badge badge-outline-success badge-button mr-5" href="/products">
                        Gestionar Productos
                    </a>
                    <a class="badge badge-outline-primary badge-button mr-5" href="/export">
                        Exportación
                    </a>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.js"></script>
    @yield('body_scripts')
</body>

@yield('script')

{{-- Global configs --}}
<script>
    //Overlays, modals config
    $(document).ready(function() {
        $('div.alert:not(.static)').delay(2500).slideUp("slow");
    });
    //GoBack Button config
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = document.referrer;
        } else {
            window.history.back();
        }
    }

</script>

</html>
