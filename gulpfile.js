var elixir = require('laravel-elixir');

var paths = {
    'jquery': './vendor/components/jquery/',
    'bootstrap': './vendor/twbs/bootstrap-sass/assets/'
}

elixir(function(mix) {
    
    // compile sass (including bootstrap)
    mix.sass("style.scss", 'public/css/', {
        includePaths: [paths.bootstrap + 'stylesheets/'],
        precision: 8
    });

    // copy bootstrap fonts
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');

    // combine scripts into single app.js
    mix.scripts(
    	[
            paths.jquery + "jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js"
        ],
        'public/js/app.js'
    );
    
});
