const mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/
// let url = process.env.APP_URL.replace(/(^\w+:|^)\/\//, '');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: true
    });

if(mix.inProduction()) {
    mix.version();
}
else {
    mix.browserSync({
        proxy: 'bg.com',
        proxyRes: [
            function (res) {
                res.headers["Expires"] = "0";
                res.headers["Cache-Control"] = "no-cache, no-store, must-revalidate";
                res.headers["Pragma"] = "no-cache";
            }
        ]
    });
}
