require ( '@vankosoft/jquery-duplicate-fields/jquery.duplicateFields.js' );

$( function()
{
	$( '#contextTagsContainer' ).duplicateFields({
        btnRemoveSelector: ".btnRemoveField",
        btnAddSelector:    ".btnAddField"
    });
});
