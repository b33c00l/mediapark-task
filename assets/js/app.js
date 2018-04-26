const $ = require('jquery');
// global.$ = global.jQuery = $;
import "bootstrap";

import dt from 'datatables.net-bs';
dt(window, $);

$(document).ready( function () {
    $('#ads').DataTable();
});

