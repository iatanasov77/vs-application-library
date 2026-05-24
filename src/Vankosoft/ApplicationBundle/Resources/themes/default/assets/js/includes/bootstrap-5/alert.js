export function ShowAlert( msgTitle, msgBody, msgType )
{
    var AlertHtml = '<div class="alert alert-dismissible" role="alert"><strong></strong><p></p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $( '#AlertsContainer' ).append( AlertHtml ); 
    
    var AlertMsg = $( 'div[role="alert"]' );
    $( AlertMsg ).find( 'strong' ).html( msgTitle );
    $( AlertMsg ).find( 'p' ).html( msgBody );
    $( AlertMsg ).addClass( 'alert-' + msgType );
    $( AlertMsg ).show();
}