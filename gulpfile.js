var elixir = require('laravel-elixir');
var gulp = require('gulp');
var tar = require('gulp-tar');
var gzip = require('gulp-gzip');
var rename = require('gulp-rename');

var package = require('./package.json');

var paths = {
    'jquery': './bower_components/jquery/',
    'bootstrap': './bower_components/bootstrap-sass/assets/',
    'leaflet': './bower_components/leaflet/',
    'leaflet_label': './bower_components/Leaflet.label/',
    'leaflet_heat': './bower_components/Leaflet.heat/',
    'd3' : './bower_components/d3/',
    'readmore' : './bower_components/readmore-js/'
};

gulp.task("dist", ["sass", "copy", "scripts"], function() {
    return gulp.src(
            [
                'app/**/*', 'bootstrap/*', 'storage/framework/*', 'config/*',
                'public/**/*', 'resources/**/*', 'vendor/**/*', '.env', 'readme.md', 'package.json'
            ],
            { base: './', dot: true }
        )
        .pipe(rename(function(path) {
            path.dirname = package.name + '-' + package.version + '/' + path.dirname;
        }))
        .pipe(tar(package.name + '-' + package.version + '.tar'))
        .pipe(gzip())
        .pipe(gulp.dest('dist'));
});

elixir(function(mix) {

    // compile sass (including bootstrap)
    mix.sass(
        [
            paths.leaflet + 'dist/leaflet.css',
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
            paths.readmore + "readmore.js",
            "*.js"
        ],
        'public/js/app.js'
    );
    
});
