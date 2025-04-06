require( '../includes/resource-delete.js' );

import { VsTranslator, VsLoadTranslations } from '../includes/bazinga_js_translations.js';
VsLoadTranslations(['VSApplicationBundle']);

$( function()
{
    $( '.btnIssueTask' ).on( 'click', function( e )
    {
        e.preventDefault();
        
        var taskId   = $( this ).attr( 'data-taskId' );
        var _Translator = VsTranslator( 'VankoSoftOrg' );
        
        $.ajax({
            type: "GET",
            url: $( this ).attr( 'href' ),
            success: function( response )
            {
                let modalTitle  = taskId == '0' ?
                                    _Translator.trans( 'vs_application.template.project_issues.create_issue_task_modal_title' ) :
                                    _Translator.trans( 'vs_application.template.project_issues.edit_issue_task_modal_title' );
                                    
                $( '#ProjectIssueTaskModalTitle' ).text( modalTitle );
                $( '#IssueTaskBody> div.card-body' ).html( response );
                
                /** Bootstrap 5 Modal Toggle */
                const myModal = new bootstrap.Modal('#ProjectIssueTaskModal', {
                    keyboard: false
                });
                myModal.show( $( '#ProjectIssueTaskModal' ).get( 0 ) );
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    $( '#btnSaveIssueTask' ).on( 'click', function( e )
    {
        $( '#ProjectIssueTaskForm' ).submit();
    });
    
    $( ".btnDeleteTask" ).on( "click", function ( e )
    {
        e.preventDefault();

        $( '#deleteResourceForm' ).attr( 'action', $( this ).attr( 'href' ) );
        $( '#resource_delete__token' ).val( $( this ).attr( 'data-csrftoken' ) );
        $( '#resource_delete__redirect' ).val( $( this ).attr( 'data-redirectUrl' ) );
        
        $( '#deleteResourceForm' ).submit();
    });
});