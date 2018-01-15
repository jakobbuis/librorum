<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.json">

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
          :md-active.sync="errors.server"
          md-content="A critical error occured while executing your request. Please reload and try again."
          md-confirm-text="Okay"></md-dialog-alert>

        {{-- Popup to force logging-in again when request fails 401 --}}
        <md-dialog :md-fullscreen="false" :md-active.sync="errors.mustLogin">
            <md-dialog-title>Login required</md-dialog-title>
            <md-dialog-content>
                You are not authorized for this page or action. Please login (again).
            </md-dialog-content>

            <md-dialog-actions>
                <md-button class="md-raised md-primary" @click="toLoginPage">To Login page</md-button>
            </md-dialog-actions>
        </md-dialog>
    </div>

    @include('configuration')
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
