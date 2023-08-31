$(document).ready ( function(){
    $('#main').css('visibility', 'visible');

    // Add event listener for opening and closing details
    $('#wonde_table').on('click', 'tbody td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
        }
    } );
 
    $('#wonde_table').on('requestChild.dt', function(e, row) {
        row.child(format(row.data())).show();
    })
 
    var table = $('#wonde_table').DataTable( {
        "rowId": 'id',
        "columns": [
            {
                "className":      'dt-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "class" },
            { "data": "subject" },
            { "data": "attendees" },
        ],
        "order": [[1, 'asc']],
        dom: 'Blfrtip',
        buttons:['createState', 'savedStates']
    } );
     
    table.on('stateLoaded', (e, settings, data) => {
        for(var i = 0; i < data.childRows.length; i++) {
            var row = table.row(data.childRows[i]);
            row.child(format(row.data())).show();
        }
    })

    $('#wonde_table').find('td:first').removeClass('dt-control');
 });

function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td style="vertical-align: text-top;"><b>Attendees:</b></td>'+
            '<td>'+d.attendees+'</td>'+
        '</tr>'+
    '</table>';
}