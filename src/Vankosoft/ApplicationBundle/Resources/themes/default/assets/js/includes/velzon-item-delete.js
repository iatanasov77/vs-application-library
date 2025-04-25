var onVelzonItemDeleteCancel  = function() {
    $( '#deleteResourceForm' ).attr( 'action', '' );
    $( '#resource_delete__token' ).val( '' );
    
    $( this ).dialog( "close" );
}

$( function()
{
	$( ".btnDeleteVelzonItem" ).on( "click", function ( e )
	{
	    e.preventDefault();
        var subsModal = document.getElementById( 'deleteRecordModal' );
        
	    $( '#deleteResourceForm' ).attr( 'action', $( this ).attr( 'href' ) );
	    $( '#resource_delete__token' ).val( $( this ).attr( 'data-csrftoken' ) );
	    $( '#resource_delete__redirect' ).val( $( this ).attr( 'data-redirectUrl' ) );
	    
	    /** Bootstrap 5 Modal Toggle */
        const myModal = new bootstrap.Modal( '#deleteRecordModal', {
            keyboard: false
        });
        
        subsModal.addEventListener( 'hide.bs.modal', onVelzonItemDeleteCancel, { once: true } );
        myModal.show( subsModal );
	});
	
	$( '#delete-record' ).on( 'click', function( e ) {
	    $( '#deleteResourceForm' ).submit();
	});
});
