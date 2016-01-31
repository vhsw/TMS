var elixir = require('laravel-elixir');

var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

// SASS
elixir(function(mix) {
    mix
    .sass(['bootstrap.scss'], 'public/global/plugins/bootstrap/css/bootstrap.css')
    .sass(['global/components.scss'], 'public/global/css/components.css')
    .sass(['global/plugins.scss'], 'public/global/css/plugins.css')
    .sass(['layouts/layout/layout.scss'], 'public/layouts/layout/css/layout.css')
    .sass(['layouts/layout/themes/darkblue.scss'], 'public/layouts/layout/css/themes/darkblue.css')
});

// Global Css
elixir(function(mix) {
    mix.styles([
        './public/global/plugins/bootstrap/css/bootstrap.css',
        './public/global/plugins/uniform/css/uniform.default.css',
        './resources/assets/css/overrides.css'
        ], 'public/css/global.css');
});

// Main Layout Css
elixir(function(mix) {
    mix.styles([
        './public/global/css/components.css',
        './public/global/css/plugins.css',
        './public/layouts/layout/css/layout.css',
        './public/layouts/layout/css/themes/darkblue.css'
    	],  'public/css/layout.css');
});


// Main Scripts
elixir(function(mix) {
    mix.scripts([
    	'./public/global/plugins/jquery.min.js',
    	'./public/global/plugins/bootstrap/js/bootstrap.min.js',
    	'./public/global/plugins/js.cookie.min.js',
    	'./public/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    	'./public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    	'./public/global/plugins/jquery.blockui.min.js',
    	'./public/global/plugins/uniform/jquery.uniform.min.js',
    	'./public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
    	'./public/global/plugins/select2/js/select2.full.min.js',
    ], 'public/js/global.js');
});


elixir(function(mix) {
    mix.copy('./resources/assets/scripts', 'public/js');
});
