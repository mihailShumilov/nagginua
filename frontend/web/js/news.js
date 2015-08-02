/**
 * Created by godson on 12/21/14.
 */
$( document ).ready( function ()
{

    jQuery( "#newsContent" ).tabs( {
        activate: function ( event, ui )
        {
            window.location.hash = ui.newPanel.selector;
        }
    } );
} );