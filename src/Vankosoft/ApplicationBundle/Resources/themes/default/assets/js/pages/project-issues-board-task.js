require( '../includes/resource-delete.js' );
require( '../includes/bootstrap-5/file-input.js' );

import lottie from "lottie-web";
import { defineElement } from "@lordicon/element";

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
///////////////////////////////////////////////////////////////////////////////////////////////////////////
import { VsPath } from '../includes/fos_js_routes.js';
import { VsTranslator, VsLoadTranslations } from '@/js/includes/bazinga_js_translations.js';
VsLoadTranslations(['VSApplicationBundle']);

import { InitOneUpFileUpload } from '../includes/OneUpFileUpload/JQueryUiProgressbar.js';
import { moveTask, saveAttachment } from '../includes/kanbanboard.js';

window.FileSaved            = false;
window.UploadedResources    = {};

var mimetype2fa = require( 'mimetype-to-fontawesome' )( { prefix: 'fa-' } );

function initTaskAttachmentField()
{
    $( '#addAttachmentModal' ).on( 'change', 'div.form-field-file input[type=file]', function()
    {
        var label       = $( this ).next();
        var fileName    = $( this ).val().split( '\\' ).pop();
        if ( fileName ) { 
            $( label ).html( fileName );
        } else { 
            $( label ).html( '' );
        }
    });
}

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
    
    $( '.btnCreateSubtaskModal' ).on( 'click', function( e )
    {
        var taskId = $( this ).attr( 'data-taskId' );
        var subTaskId = $( this ).attr( 'data-subTaskId' );
        
        $.ajax({
            type: "GET",
            url: VsPath( 'vsorg_kanbanboard_task_get_subtask_form', { 'taskId': taskId, 'subTaskId': subTaskId } ),
            success: function( response )
            {
                var _Translator = VsTranslator( 'VSApplicationBundle' );
                $( '#createSubtaskModalLabel' ).text( _Translator.trans( 'vs_application.template.project_issues.create_sub_task' ) );
                $( '#modalSubtask > div.card-body' ).html( response );
                
                /** Bootstrap 5 Modal Toggle */
                const myModal = new bootstrap.Modal( '#createSubtaskModal', {
                    keyboard: false
                });
                myModal.show( $( '#createSubtaskModal' ).get( 0 ) );
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    $( '#btnCreateSubtask' ).on( 'click', function ( e )
    {
        $( '#form-kanbanboard-subtask' ).submit();
    });
    
    $( '#modalSubtask' ).on( 'click', '#btnCreateIssue', function( e )
    {
        var pipelineId      = $( this ).attr( 'data-pipelineId' );
        var parentTaskId    = $( this ).attr( 'data-parentTaskId' );
        
        $.ajax({
            type: "GET",
            url: VsPath( 'vsorg_kanbanboard_task_create_issue', {'pipelineId': pipelineId, 'parentTaskId': parentTaskId} ),
            success: function( response )
            {
                var _Translator = VsTranslator( 'VSApplicationBundle' );
                $( '#createSubtaskModalLabel' ).text( _Translator.trans( 'vs_application.template.project_issues.create_issue' ) );
                
                $( '#modalSubtask > div.card-body' ).html( response );
                
                var tagsInputWhitelist  = $( '#project_issue_form_labelsWhitelist' ).val().split( ',' );
                //console.log( tagsInputWhitelist );
                
                tagsInput   = $( '#project_issue_form_labels' )[0];
                tagify      = new Tagify( tagsInput, {
                    whitelist : tagsInputWhitelist,
                    dropdown : {
                        classname     : "color-blue",
                        enabled       : 0,              // show the dropdown immediately on focus
                        maxItems      : 5,
                        position      : "text",         // place the dropdown near the typed text
                        closeOnSelect : false,          // keep the dropdown open after selecting a suggestion
                        highlightFirst: true
                    }
                });
                
                // bind "DragSort" to Tagify's main element and tell
                // it that all the items with the below "selector" are "draggable"
                dragsort    = new DragSort( tagify.DOM.scope, {
                    selector: '.'+tagify.settings.classNames.tag,
                    callbacks: {
                        dragEnd: onDragEnd
                    }
                });
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    $( '#modalSubtask' ).on( 'submit', '#btnCreateIssueForm', function( e )
    {
        e.preventDefault();
        
        var form        = $( this );
        var actionUrl   = form.attr( 'action' );
        
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function( response )
            {
                var taskUrl = VsPath( 'vsorg_kanbanboard_pipeline_create_task', {
                    'pipelineId': response.payload.pipelineId,
                    'issueId': response.payload.issueId
                });
                
                $.ajax({
                    type: "GET",
                    url: taskUrl,
                    success: function( response )
                    {
                        var _Translator = VsTranslator( 'VSApplicationBundle' );
                        $( '#createSubtaskModalLabel' ).text( _Translator.trans( 'vs_application.template.project_issues.create_sub_task' ) );
                        $( '#modalSubtask > div.card-body' ).html( response );
                        
                        flatpickr( "#kanban_board_create_task_form_dueDate", {
                            dateFormat: "d M, Y",
                            defaultDate: $( "#kanban_board_create_task_form_dueDate" ).val(),
                        });
                    },
                    error: function()
                    {
                        alert( "SYSTEM ERROR!!!" );
                    }
                });
            },
            error: function()
            {
                alert( "SYSTEM ERROR!!!" );
            }
        });
    });
    
    initTaskAttachmentField();
});
