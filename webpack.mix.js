let mix = require('laravel-mix');

// Nova path for local development, which uses a symlink for development, and breaks local paths
// let nova_path =  path.resolve(__dirname, '../../vendor/laravel/nova/resources/js/');
let nova_path = 'F:\\Code\\laravel-accounting\\vendor\\laravel\\nova\\resources\\js';

console.log(nova_path);

mix.setPublicPath('dist')
    .js('resources/js/tool.js', 'js')
    .sass('resources/sass/tool.scss', 'css')
    .webpackConfig({
        resolve: {
            alias: {
                '@nova': nova_path
            }
        }
    })