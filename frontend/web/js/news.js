/**
 * Created by godson on 12/21/14.
 */
$( document ).ready( function ()
{
    console.log( 'NEWS.JS' );
    $( ".sourceSwitch" ).click( function ()
    {
        $( ".pendingNews" ).hide();
        $( "#" + $( this ).attr( "href" ).substr( 1 ) ).show();
    } );

    if ($( location ).attr( 'hash' )) {
        $( $( location ).attr( 'hash' ) ).show();
    } else {
//        $(".sourceSwitch:first").click();
    }

    jQuery( "#newsContent" ).tabs();
} );