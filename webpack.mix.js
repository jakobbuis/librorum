let mix = require('laravel-mix');

mix.disableSuccessNotifications();

mix.js('resources/assets/js/app.js', 'public/js').version().sourceMaps();
mix.sass('resources/assets/sass/app.scss', 'public/css').version().sourceMaps();

mix.js('resources/assets/js/serviceworker/worker.js', 'public').version().sourceMaps();
