function _datatable(title, left = 1, right = 1, tbl = 'tbl', print_mode = 'portrait', isFooter = 0) {
    $('#' + tbl).DataTable({
        dom: 'lBfrtip',
        processing: true,
        scrollY: '450px',
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        responsive: true,
        stateSave: true,
        colReorder: true,
        fixedColumns: {
            left: left,
            right: right
        },
        buttons: [
            {
                extend: 'copy',
                text: 'Copy',
                exportOptions: {
                    columns: ':not(.not-export)'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                filename: title.replace(/ /g, '_').toLowerCase() + '_' + $.now(),
                title: title,
                exportOptions: {
                    columns: ':not(.not-export)'
                },
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c', sheet).attr('s', '25');
                }
            },
            {
                extend: 'print',
                text: 'Print',
                title: title,
                footer: true,
                exportOptions: {
                    columns: ':not(.not-export)'
                },
                customize: function (win) {
                    /* Stop repeating footer on every page */
                    $(win.document.head).append('<style>@media print {tfoot {display: table-row-group !important;}} @page { size: ' + print_mode + '; } body { font-size: 12px; } table.dataTable { font-size: 12px; }</style>');
                    $(win.document.body)
                    .find('h1').css('text-align', 'center')
                    .css('font-size', '14pt')
                    .prepend(
                            '<table width="100%"><tr><td width="20%" align="right"><img src="http://payroll.ccardbltd.localhost/assets/images/contai.png" alt="logo" height="100" width="100" /></td><td align="center"><h4>CONTAI CO-OPERATIVE AGRICULTURE & RURAL DEVELOPMENT BANK LTD.</h4> <h5><i>(REGD. No.-10, Cont. Date-01.02.1967)</i></h5> <h5>P.O.- CONTAI, DIST.- PURBA MEDINIPUR</h5> <h5>WEST BENGAL, 721401</h5></td></tr></table>'
                    );
                    // $(win.document.body)
                    // .css('font-size', '10pt')
                    // .append('<div id="print-footer" style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px;"><hr><table width="100%"><tr><td align="left"><p>Prepared By</p></td><td align="center"><p>Checked By</p></td><td align="right"><p>Chief Executive Officer</p></td></tr></table></div>');
                    if(isFooter > 0)  {
                        $(win.document.body)
                        .css('font-size', '10pt')
                        .append('<div id="print-footer" style="margin-top:50px; text-align:center; font-size:12px;"><hr><table width="100%"><tr><td align="left"><p>Prepared By</p></td><td align="center"><p>Checked By</p></td><td align="right"><p>Chief Executive Officer</p></td></tr></table></div>');
                    }
                    

                    // $(win.document.body)
                    // .find('table')
                    // .addClass('compact')
                    // .css('font-size', 'inherit')
                    // .css('margin', '50px auto');
                }
            }
        ]
    });
}
