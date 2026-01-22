import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import './toast';

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});