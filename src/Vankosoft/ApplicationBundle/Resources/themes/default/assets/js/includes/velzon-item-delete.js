var onResourceDeleteCancel  = function() {
    $( '#deleteResourceForm' ).attr( 'action', '' );
    $( '#resource_delete__token' ).val( '' );
    
    $( this ).dialog( "close" );
}

$( function()
{
	$( ".btnDeleteVelzonItem" ).on( "click", function ( e )
	{
	    e.preventDefault();

	    $( '#deleteResourceForm' ).attr( 'action', $( this ).attr( 'href' ) );
	    $( '#resource_delete__token' ).val( $( this ).attr( 'data-csrftoken' ) );
	    $( '#resource_delete__redirect' ).val( $( this ).attr( 'data-redirectUrl' ) );
	    
	    var subsModal = document.getElementById( 'removeNotificationModal' );
	    
	    /** Bootstrap 5 Modal Toggle */
        const myModal = new bootstrap.Modal( '#removeNotificationModal', {
            keyboard: false
        });
        
        subsModal.addEventListener( 'hide.bs.modal', function() {
            alert(2);
        }, {
            once: true
        });
         
        myModal.show( subsModal );
	});
	
	$( '#delete-notification' ).on( 'click', function( e ) {
	    $( '#deleteResourceForm' ).submit();
	});
});
