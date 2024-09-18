<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <lord-icon
                src="//cdn.lordicon.com/xzalkbkz.json"
                trigger="loop"
                delay="1000"
                style="width:150px;height:150px">
            </lord-icon>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="//cdn.lordicon.com/lordicon.js"></script>
        <script>
            $(document).ready(function(){
                $('#adminLogInBtn').click(function() {
                    $('#email').val('system@admin.com');
                    $('#password').val('123456');
                });
                $('#userLogInBtn').click(function() {
                    $('#email').val('system@user.com');
                    $('#password').val('123456');
                });
            });

        </script>
    </body>
</html>
