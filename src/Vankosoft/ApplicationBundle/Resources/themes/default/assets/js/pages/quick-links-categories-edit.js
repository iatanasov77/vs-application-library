require( '../includes/resource-delete.js' );

import { VsPath } from '../includes/fos_js_routes.js';
import VsSortable from '../includes/sortable';
const siSortable  = new VsSortable( 'vs_cms__ext_sort_action' );

$( function()
{
    // bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
    $( '#FormContainer' ).on( 'change', '#quick_links_category_form_currentLocale', function( e ) {
        var placeId  = $( '#FormContainer' ).attr( 'data-itemId' );
        var locale  = $( this ).val();
        
        if ( placeId ) {
            $.ajax({
                type: 'GET',
                url: VsPath( 'vvp_slider_form_in_locale', { 'itemId': placeId, 'locale': locale } ),
                success: function ( data ) {
                    $( '#FormContainer' ).html( data );
                }, 
                error: function( XMLHttpRequest, textStatus, errorThrown ) {
                    alert( 'FATAL ERROR!!!' );
                }
            });
        }
    });
    
    let sortableIds;
    $( "#quickLinksTableBody" ).sortable({
        start: function( event, ui ) {
            sortableIds = $( "#quickLinksTableBody" ).sortable( "toArray" );
            //console.log( sortableIds );
        },
        
        update: function( event, ui ) {
            var itemId      = ui.item.attr( "data-node-id" );
            var sortedIDs   = $( "#quickLinksTableBody" ).sortable( "toArray" );
            var itemIndex   = sortedIDs.indexOf( 'quickLink-' + itemId );
            
            var sortedItems = [];
            for ( let i = 0; i < sortedIDs.length; i++ ) {
                sortedItems.push( $( '#' + sortedIDs[i] ).attr( 'data-node-id' ) );
            }
            //console.log( sortedIDs );
            //console.log( sortedItems );
            //alert( "Position: " + ui.position.top + " Original Position: " + ui.originalPosition.top );
            
            let insertAfterId = siSortable.getInsertAfterId( itemIndex, sortedItems );
            siSortable.changeOrderNew( itemId, insertAfterId );
        }
    });
});
