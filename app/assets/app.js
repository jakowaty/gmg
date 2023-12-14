/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import 'bootstrap';
import './AdminLTE-3.1.0/js/AdminLTE'
import './styles/app.scss';
// start the Stimulus application
import './bootstrap';
const {defaults} = require('@pnotify/core');
defaults.sticker = false;
defaults.closer = false;

import Cookies from 'js-cookie';

$('select[name="limit"]').change(function (e) {
    let url = new URL(window.location.href);
    url.searchParams.set('limit', e.target.value);
    url.searchParams.set('page', 1);
    location.href = url.toString();
});

window.setTimeout(function () {
    $(".alert").alert('close');
}, 3000);

$('a[data-widget="pushmenu"]').click(function (e){
    e.preventDefault();
    Cookies.set('menu', $("body").hasClass('sidebar-collapse') ? '1' : '0');
});