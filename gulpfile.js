/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

var bootstrap_sass = './node_modules/bootstrap-sass/';

elixir(mix => {
    // copy bootstrap fonts to public folder
    mix.copy(bootstrap_sass+"assets/fonts/bootstrap",'public/fonts');

    mix.sass('app.scss')
       .webpack('app.js');
});
