require( '../includes/resource-delete.js' );
require( '../includes/bootstrap-5/file-input.js' );

import lottie from "lottie-web";
import { defineElement } from "@lordicon/element";

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
///////////////////////////////////////////////////////////////////////////////////////////////////////////
import { VsPath } from '../includes/fos_js_routes.js';
import { InitOneUpFileUpload } from '../includes/OneUpFileUpload/JQueryUiProgressbar.js';

import { moveTask, saveAttachment } from '../includes/kanbanboard.js';

window.FileSaved            = false;
window.UploadedResources    = {};

var mimetype2fa = require( 'mimetype-to-fontawesome' )( { prefix: 'fa-' } );

$( function ()
{
    $( '#SelectBoxPipeline' ).on( 'change', function ( e ) {
        let taskId      = $( this ).attr( 'data-taskId' );
        let pipelineId  = $( this ).val();
        
        var redirectPath = VsPath( 'vs_application_project_issues_kanbanboard_show' );
        moveTask( taskId, pipelineId, redirectPath );
    });
    
    $( 'div.card-file-icon' ).each( function( index )
    {
        $( this ).children( ":first" ).addClass( mimetype2fa( $( this ).attr( 'data-MimeType') ) );
    });
    
    $( 'div.tab-file-icon' ).each( function( index )
    {
        $( this ).children( ":first" ).addClass( mimetype2fa( $( this ).attr( 'data-MimeType') ) );
    });
    
    if ( $( '#MemberPhotoInternalLabel' ).hasClass( 'required' ) ) {
        $( '#MemberPhotoInternalLabel' ).removeClass( 'required' );
        $( '#MemberPhotoExternalLabel' ).addClass( 'required' );
    }
    
    // define "lord-icon" custom element with default properties
    defineElement( lottie.loadAnimation );
    
    $( '#btnAssignMember' ).on( 'click', function( e )
    {
        var taskId = $( this ).attr( 'data-taskId' );
        var memberId = $( this ).attr( 'data-memberId' );
        
        $.ajax({
            type: "GET",
            url: VsPath( 'vs_application_project_issues_kanbanboard_task_assign_member', {'taskId': taskId, 'memberId': memberId } ),
            success: function( response )
            {
                document.location = document.location
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    $( '.btnAddAttachmentModal' ).on( 'click', function( e )
    {
        var taskId = $( this ).attr( 'data-taskId' );
        
        $.ajax({
            type: "GET",
            url: VsPath( 'vs_application_project_issues_kanbanboard_task_get_attachment_form', { 'taskId': taskId } ),
            success: function( response )
            {
                $( '#modalAttachment > div.card-body' ).html( response );
                
                /** Bootstrap 5 Modal Toggle */
                const myModal = new bootstrap.Modal( '#addAttachmentModal', {
                    keyboard: false
                });
                myModal.show( $( '#addAttachmentModal' ).get( 0 ) );
                
                $( '#kanban_board_task_attachment_form_file' ).on( 'change', function( e )
                {
                    window.jQueryFileUpload = true;
                });
                
                InitOneUpFileUpload({
                    fileuploadSelector: "#OneUpFileUpload",
                    fileinputSelector: "#kanban_board_task_attachment_form_attachment",
                    btnStartUploadSelector: "#btnAddAttachment",
                    
                    progressbarSelector: "#FileUploadProgressbar",
                    
                    requestType: "VankosoftApi",
                    requestTarget: "VankosoftApi_TaskAttachment",
                    fileInputFieldName: "attachment",
                    fileResourceKey: "VsOrg_KanbanBoardTaskAttachment",
                    fileResourceId: $( '#kanban_board_task_attachment_form_id' ).val(),
                    fileOwnerId: $( '#FileOwnerId' ).val(),
                    maxChunkSize: 10000000
                });
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    window.addEventListener( 'resourceUploaded', event => {
        if ( event.detail.resourceKey && event.detail.resourceId ) {
            window.UploadedResources[event.detail.resourceKey]  = event.detail.resourceId;
        }
        
        if (
            "VsOrg_KanbanBoardTaskAttachment" in window.UploadedResources &&
            window.UploadedResources["VsOrg_KanbanBoardTaskAttachment"] &&
            ! window.FileSaved
        ) {
            saveAttachment();
            window.FileSaved   = true;
        }
    });
});
