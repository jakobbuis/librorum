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
        {{-- Generic confirmation bar  --}}
        <confirmation-bar
            :text="confirmation.text"
            :undo-callback="confirmation.undoCallback">
        </confirmation-bar>

        {{-- Main UI --}}
        <router-view></router-view>

        {{-- Axios global error handling --}}
        <md-dialog-alert
          :md-active.sync="axiosError"
          md-content="A critical error occured while executing your request. Please reload and try again."
          md-confirm-text="Okay" />

    </div>

    @include('configuration')
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
