// Call the dataTables jQuery plugin
$(document).ready(function () {

    var currentdate = new Date();
    var datetime = currentdate.getDate() + ""
        + (currentdate.getMonth() + 1) + ""
        + currentdate.getFullYear() + "_"
        + currentdate.getHours() + ""
        + currentdate.getMinutes() + ""
        + currentdate.getSeconds();


    $('#dataTable').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'users_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'USERS_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'USERS_' + datetime,
                messageTop: 'List of users',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of users',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },

        ],

        //? Pri ucitavanju po defaultu da kolona Action(-1) bude nevidljiva
        // -2 je kolona created at itd.
        columnDefs: [{
            targets: [-4, -2], // -1 je zadnja kolona
            visible: false,
        }],
        order: [[1, 'desc']], //? sortiraj po datumu registracije
    });


    //? Posts
    let dataTablePosts = $('#dataTablePosts').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'posts_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'POSTS_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'POSTS_' + datetime,
                messageTop: 'List of posts',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of posts',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },

        ],

        // columnDefs: [{
        //     orderable: false,
        //     className: 'select-checkbox',
        //     targets: 0
        // }],
        // select: {
        //     style: 'multi',
        //     selector: 'td:first-child'
        // },
        order: [[1, 'desc']]
    });


    //? Roles
    $('#dataTableRoles').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'roles_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Roles_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Roles_' + datetime,
                messageTop: 'Roles list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of posts',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },

        ],

        //? Pri ucitavanju po defaultu da kolona Action(-1) bude nevidljiva
        // -2 je kolona created at itd.
        // columnDefs: [{
        //     targets: [-4, -2], // -1 je zadnja kolona
        //     visible: false,
        // }],
        order: [[0, 'asc']], //? sortiraj po datumu registracije
    });


    //? Permissions
    $('#dataTablePermissions').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'roles_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Permissions_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Permissions_' + datetime,
                messageTop: 'Permissions list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of permissions',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },

        ],

        columnDefs: [{
            targets: [-2], // -1 je zadnja kolona
            visible: false,
        }],
        order: [[0, 'asc']], //? sortiraj po datumu registracije
    });

    //? Categories
    $('#dataTableCategories').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'categories_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Categories_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Categories_' + datetime,
                messageTop: 'Categories list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of categories',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        // columnDefs: [{
        //     targets: [-2], //
        //     visible: false,
        // }],
        order: [[0, 'desc']],
    });

    //? Coupons
    $('#dataTableCoupons').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'Coupons_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Coupons_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Coupons_' + datetime,
                messageTop: 'Coupons list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of categories',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        // columnDefs: [{
        //     targets: [-2], //
        //     visible: false,
        // }],
        order: [[0, 'desc']],
    });

    //? Tags
    $('#dataTableTags').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'roles_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Permissions_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Permissions_' + datetime,
                messageTop: 'Permissions list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of permissions',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        // columnDefs: [{
        //     targets: [-2], //
        //     visible: false,
        // }],
        order: [[0, 'asc']],
    });

    //? Comments
    $('#dataTableComments').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'comments_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Comments_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Comments_' + datetime,
                messageTop: 'Comments list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of comments',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        // columnDefs: [{
        //     targets: [-2], //
        //     visible: false,
        // }],
        order: [[0, 'desc']],
    });

    //? Products
    $('#dataTableProducts').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'posts_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'PRODUCTS_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'PRODUCTS_' + datetime,
                messageTop: 'List of products',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of products',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },

        ],

        // columnDefs: [{
        //     targets: [-2, -3, -4],
        //     visible: false,
        // }],

        // order: [[1, 'desc']]
    });

    //? Orders
    $('#dataTableOrders').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'orders_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'ORDERS_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'ORDERS_' + datetime,
                messageTop: 'List of orders',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6],
                    columns: ':visible'
                },
            },
            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of orders',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');
                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        columnDefs: [{
            targets: [-2, -8, -9, -10, -11, -12, -13, -14, -15, -17],
            visible: false,
        }],

        // order: [[1, 'desc']]
    });

    //? Primatech API Clients
    $('#dataTableApi').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            {
                extend: 'colvis',
                className: 'btn-dark',
                text: '<i class="fas fa-eye"></i>',
            },
            {
                extend: 'copyHtml5',
                footer: true,
                className: 'btn-secondary',
                text: '<span>Copy</span> <i class="far fa-copy"></i>'
            },
            {
                text: '<span>JSON</span> <i class="fas fa-code"></i>',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)]),
                        'clients_' + datetime + '.json',
                    );
                },
            },
            {
                extend: 'excelHtml5',
                text: '<span>Excel</span> <i class="far fa-file-excel"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Categories_' + datetime,
                autoFilter: true,
                exportOptions: {
                    columns: ':visible',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<span>PDF</span> <i class="far fa-file-pdf"></i>',
                footer: true,
                className: 'btn-secondary',
                title: 'Clients' + datetime,
                messageTop: 'Clients list',
                pageSize: 'A4',
                download: 'open',
                orientation: 'landscape',
                exportOptions: {
                    // columns: [0, 1, 2, 3, 4, 5, 6], // fiksni odabir kolona za pdf export
                    columns: ':visible' // dinamicki odabir kolona za pdf export
                },
            },

            {
                extend: 'print',
                text: '<span>Print</span> <i class="fas fa-print"></i>',
                title: 'List of clients',
                className: 'btn btn-secondary',
                orientation: 'landscape',
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);

                    $(win.document.body)
                        .css('font-size', '12.5pt');
                    // .prepend(
                    //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    // );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('border', '1px solid #000');

                    $(win.document.body).find('table td').css('border', '1px solid #000');
                    $(win.document.body).find('table th').css('border', '1px solid #000');


                },
                // autoPrint: false,
                exportOptions: {
                    columns: ':visible'
                },
            },
        ],

        columnDefs: [{
            targets: [-4, -3, -5], //
            visible: false,
        }],
        order: [[0, 'desc']],
    });
});




