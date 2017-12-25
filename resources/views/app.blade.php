<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Librorum</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
    <div id="app">
        <div class="page-container">
            <md-app>
                <md-app-toolbar class="md-primary">
                    <span class="md-title">Librorum</span>
                </md-app-toolbar>

                <md-app-content>
                    <router-view></router-view>
                </md-app-content>
            </md-app>
        </div>
    </div>

    @include('configuration')
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
