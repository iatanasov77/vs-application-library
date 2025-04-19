///////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
///////////////////////////////////////////////////////////////////////////////////////////////////////////
import { VsPath } from './fos_js_routes.js';
import { VsFormSubmit } from './vs_form.js';

/**
 * Kanbanboard Helper Functions
 */
export function moveTask( taskId, pipelineId, redirectPath )
{
    var url = VsPath( 'vs_application_project_issues_kanbanboard_task_move', {'taskId': taskId, 'pipelineId': pipelineId } );
    //alert( url ); return;
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            document.location = redirectPath
        },
        error: function()
        {
            alert( "SYSTEM ERROR!!!" );
        }
    });
}

export function saveAttachment()
{
    var formData    = new FormData();
    
    formData.set( "attachmentId", window.UploadedResources["VsOrg_KanbanBoardTaskAttachment"] );
    
    var submitUrl   = $( '#TaskAttachmentForm' ).attr( 'action' );
    var redirectUrl = VsPath( 'vs_application_project_issues_kanbanboard_task_show', {'taskId': $( '#FileOwnerId' ).val() } );
    
    VsFormSubmit( formData, submitUrl, redirectUrl );
}
 