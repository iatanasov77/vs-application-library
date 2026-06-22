require( 'jquery-easyui/css/easyui.css' );
require( 'jquery-easyui/js/jquery.easyui.min.js' );

// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
import { VsPath } from '../includes/fos_js_routes.js';

import { VsFormSubmit } from '../includes/vs_form.js';
import { VsTranslator, VsLoadTranslations } from '../includes/bazinga_js_translations.js';
VsLoadTranslations(['VSCmsBundle']);


import { EasyuiCombobox } from '@vankosoft/jquery-easyui-extensions/EasyuiCombobox.js';
import { VsRemoveDuplicates } from '../includes/vs_remove_duplicates.js';
require( '@vankosoft/jquery-easyui-extensions/EasyuiCombobox.css' );

// WORKAROUND: Prevent Double Submiting
global.btnSaveQuickLinkClicked = window.btnSaveQuickLinkrClicked = false;

function initQuickLinksCategoriesCombo()
{
    let selectedCategories  = JSON.parse( $( '#quick_link_form_selectedCategories' ).val() );
    if ( ! selectedCategories.length ) {
        selectedCategories    = null;
    }
    
    EasyuiCombobox( $( '#quick_link_form_categories' ), {
        required: true,
        multiple: true,
        checkboxId: "QuickLinkCategories",
        values: selectedCategories
    });
}

$( function()
{
    $( '#containerQuickLinks' ).on( 'click', '.btnQuickLink', function( e )
    {
        e.preventDefault();
        
        var categoryId     = $( this ).attr( 'data-categoryId' );
        var itemId      = $( this ).attr( 'data-itemId' );
        var _Translator = VsTranslator( 'VSCmsBundle' );
        
        $.ajax({
            type: "GET",
            url: VsPath( 'vs_cms_quick_link_ext_edit', {'categoryId': categoryId, 'itemId': itemId} ),
            success: function( response )
            {
                let modalTitle  = itemId == '0' ?
                                    _Translator.trans( 'vs_cms.modal.quick_link.create_title' ) :
                                    _Translator.trans( 'vs_cms.modal.quick_link.update_title' );
                                    
                $( '#modalTitle' ).text( modalTitle );
                $( '#modalBodyQuickLink > div.card-body' ).html( response );
                initQuickLinksCategoriesCombo();
                
                /** Bootstrap 5 Modal Toggle */
                const myModal = new bootstrap.Modal('#quickLinkModal', {
                    keyboard: false
                });
                myModal.show( $( '#quickLinkModal' ).get( 0 ) );
                
                /**
                 * FIXING THE MODAL/CKEDITOR ISSUE. При мен се случваше само на диалога за Снимка.
                 * --------------------------------------------------------------------------------------
                 * https://stackoverflow.com/questions/19570661/ckeditor-plugin-text-fields-not-editable
                 */
                $( '#quickLinkModal' ).removeAttr( "tabindex" );
                
                $( '#quickLinkModal' ).attr( "data-categoryId", categoryId );
                $( '#quickLinkModal' ).attr( "data-itemId", itemId );
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    $( '#quickLinkModal' ).on( 'change', '#quick_link_form_locale', function( e )
    {
        var categoryId  = parseInt( $( '#quickLinkModal' ).attr( 'data-categoryId' ) );
        var itemId      = parseInt( $( '#quickLinkModal' ).attr( 'data-itemId' ) );
        var locale      = $( this ).val()
        
        if ( itemId ) {
            $.ajax({
                type: 'GET',
                url: VsPath( 'vs_cms_quick_link_ext_edit', {'categoryId': categoryId, 'itemId': itemId, 'locale': locale} ),
                success: function ( response ) {
                    $( '#modalBodyQuickLink > div.card-body' ).html( response );
                }, 
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert( 'FATAL ERROR!!!' );
                }
            });
        }
    });
    
    $( '#btnSaveQuickLink' ).on( 'click', function( e )
    {
        if ( window.btnSaveQuickLinkClicked ) {
            return;
        }
        window.btnSaveQuickLinkClicked = true;
        
        var categoryId  = $( '#FormContainer' ).attr( 'data-categoryId' );
        var formData    = new FormData( $( '#FormQuickLink' )[ 0 ] );
        var submitUrl   = $( '#FormQuickLink' ).attr( 'action' );
        var redirectUrl = VsPath( 'vs_cms_quick_link_category_update', {'id': categoryId} );
        
        VsFormSubmit( formData, submitUrl, redirectUrl );
    });
    
    VsRemoveDuplicates();
});
