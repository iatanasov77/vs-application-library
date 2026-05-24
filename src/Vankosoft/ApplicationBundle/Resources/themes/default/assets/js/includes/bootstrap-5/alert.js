export function ShowAlert( msg_title, msg_body, msg_type )
{
    var AlertMsg = $( 'div[role="alert"]' );
    
    $( AlertMsg ).find( 'strong' ).html( msg_title );
    $( AlertMsg ).find( 'p' ).html( msg_body );
    $( AlertMsg ).removeAttr( 'class' );
    $( AlertMsg ).addClass( 'alert alert-' + msg_type );
    $( AlertMsg ).show();
}