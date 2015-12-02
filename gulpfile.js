var elixir = require('laravel-elixir');

var paths = {
    'jquery': './bower_components/jquery/',
    'bootstrap': './bower_components/bootstrap-sass/assets/',
    'leaflet': './bower_components/leaflet/',
    'leaflet_label': './bower_components/Leaflet.label/',
    'leaflet_heat': './bower_components/Leaflet.heat/',
    'd3' : './bower_components/d3/',
    'c3' : './bower_components/c3/'
};

elixir(function(mix) {

    // compile sass (including bootstrap)
    mix.sass(
        [
            paths.leaflet + 'dist/leaflet.css',
            paths.c3 + 'c3.css',
            paths.leaflet_label + 'dist/leaflet.label.css',
            'style.scss'
        ],
        'public/css/style.css',
        {
            includePaths: [paths.bootstrap + 'stylesheets/'],
            precision: 10
        }
    );

    // copy bootstrap fonts
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');

    // copy leaflet image files
    mix.copy(paths.leaflet + 'dist/images/**', 'public/img/leaflet/default');

    // combine scripts into single app.js
    mix.scripts(
    	[
            paths.jquery + "dist/jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.leaflet + "dist/leaflet.js",
            paths.leaflet_label + "dist/leaflet.label.js",
            paths.leaflet_heat + "dist/leaflet-heat.js",
            paths.d3 + "d3.js",
            paths.c3 + "c3.js",
            "*.js"
        ],
        'public/js/app.js'
    );
    
});
