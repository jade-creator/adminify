<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        @vite('resources/js/app.js')
    </head>
    <body class="antialiased">
        <div id="app"></div>

        @vite('resources/js/app.js')
        <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
        <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/adminlte/dist/js/adminlte.min.js"></script>
        <script src="/adminlte/plugins/toastr/toastr.min.js"></script>
        <script src="/adminlte/plugins/moment/moment.min.js"></script>

        <script>
            const toastrAlert = {
                default: (message) => toastr.success(message),
                info: (message) => toastr.info(message),
                warning: (message) => toastr.warning(message),
                error: (message) => toastr.error(message),
            }
        </script>
    </body>
</html>
