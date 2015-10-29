var elixir = require('laravel-elixir');

var paths = {
    'jquery': './vendor/components/jquery/',
    'bootstrap': './vendor/twbs/bootstrap-sass/assets/',
    'leaflet': './vendor/drmonty/leaflet/'
};

elixir(function(mix) {
    
    // compile sass (including bootstrap)
    mix.sass(['style.scss', paths.leaflet + 'css/leaflet.css'], 'public/css/style.css', {
        includePaths: [paths.bootstrap + 'stylesheets/'],
        precision: 8
    });

    // copy bootstrap fonts
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');

    // copy leaflet image files
    mix.copy(paths.leaflet + 'images/**', 'public/img/leaflet/');

    // combine scripts into single app.js
    mix.scripts(
    	[
            paths.jquery + "jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.leaflet + "js/leaflet.js",
            "/js/*.js"
        ],
        'public/js/app.js'
    );
    
});
