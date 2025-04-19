import './file-input.css';

$( function()
{
    $( document ).on( 'change', 'div.form-field-file input[type=file]', function()
    {
        var label       = $( this ).next();
        var fileName    = $( this ).val().split( '\\' ).pop();
        if ( fileName ) {
            $( label ).html( fileName );
        } else {
            $( label ).html( 'Choose File' );
        }
    });
});
