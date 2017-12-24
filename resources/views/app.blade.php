<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Librorum</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

                <layout-header></layout-header>

                <main class="mdl-layout__content">
                    <div class="page-content">
                        <router-view></router-view>
                    </div>
                </main>
            </div>
        </div>

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
        <link rel="stylesheet" href="https://unpkg.com/vue-material@beta/dist/theme/default.css">
        @include('configuration')
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
