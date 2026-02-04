
export function GetCkEditorData( fieldId )
{
    var description;
    
    if ( useCkEditor == '5' ) {
        let editor = editors[fieldId];
        description = editor.getData();
    } else {
        require( 'ckeditor4/ckeditor.js' );
        description = CKEDITOR.instances[fieldId].getData();
    }
    
    return description;
}
