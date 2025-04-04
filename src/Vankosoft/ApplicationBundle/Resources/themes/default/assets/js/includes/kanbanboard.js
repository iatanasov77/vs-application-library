///////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
///////////////////////////////////////////////////////////////////////////////////////////////////////////
import { VsPath } from '@/js/includes/fos_js_routes.js';

/**
 * Kanbanboard Helper Functions
 */
export function moveTask( taskId, pipelineId )
{
    var url = VsPath( 'vs_application_project_issues_kanbanboard_task_move', {'taskId': taskId, 'pipelineId': pipelineId } );
    //alert( url ); return;
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            document.location = document.location
        },
        error: function()
        {
            alert( "SYSTEM ERROR!!!" );
        }
    });
}
 