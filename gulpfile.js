var elixir = require('laravel-elixir');

var paths = {
    'jquery': './vendor/components/jquery/',
    'bootstrap': './vendor/twbs/bootstrap-sass/assets/',
    'leaflet': './vendor/drmonty/leaflet/'
};

elixir(function(mix) {
    
    // compile sass (including bootstrap)
    mix.sass('style.scss', 'public/css/', {
        includePaths: [paths.bootstrap + 'stylesheets/'],
        precision: 8
    });

    // combine css files
    mix.styles(['public/css/style.css', paths.leaflet + 'css/leaflet.css'], 'public/css/style.css', './');

    // copy bootstrap fonts
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');

    // copy leaflet image files
    mix.copy(paths.leaflet + 'images/**', 'public/img/leaflet/');

    // combine scripts into single app.js
    mix.scripts(
    	[
            paths.jquery + 'jquery.js',
            paths.bootstrap + 'javascripts/bootstrap.js',
            paths.leaflet + 'js/leaflet.js'
        ],
        'public/js/app.js'
    );
    
});
