<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RailcarApp</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>

    <body>
        @if (Auth::check())
        @php
        $user_auth_data = [
        'isLoggedin' => true,
        'user' => Auth::user()
        ];
        @endphp
        @else
        @php
        $user_auth_data = [
        'isLoggedin' => false
        ];
        @endphp
        @endif
        <script>
            window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
        </script>

        <div class="container">
            <div id="app">

            </div>
        </div>


        <script src="{{mix('js/app.js')}}"></script>

    </body>

</html>
