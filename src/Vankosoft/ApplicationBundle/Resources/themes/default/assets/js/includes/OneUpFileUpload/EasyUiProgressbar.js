require( 'jquery-easyui/css/easyui.css' );
require( './EasyUiProgressbar.css' );
require( 'jquery-easyui/js/jquery.easyui.min.js' );
require( 'blueimp-file-upload/js/jquery.fileupload.js' );

import { humanFileSize } from '../humanFileSize.js';

window.UploadedFiles                = [];
window.TestUploadProgressBarData    = {
    loaded: 0,
    total: 1000000000
};

/**
 * options
 * {
 *     fileuploadSelector: "#OneUpFileUpload",
 *     fileinputSelector: "#upload_file_form_file",
 *     btnStartUploadSelector: "#btnSaveUploadFile",
 *
 *     progressbarSelector: "#FileUploadProgressbar",
 *
 *     fileInputFieldName: "file",
 *     fileResourceId: 0,
 *     fileResourceKey: "",
 *     fileResourceClass: "",
 *     maxChunkSize: 10000000
 * }
 */
export function InitOneUpFileUpload( options, preFormSubmit = null )
{
    validateOptions( options );
    
    $.extend( $.fn.progressbar.defaults, {
        sizeUploaded: 0,
        sizeTotal: 0
    });
    
    ///////////////////////////////////////////////////////////////////////
    // https://github.com/blueimp/jQuery-File-Upload/wiki/Options
    ///////////////////////////////////////////////////////////////////////
    $( options.fileuploadSelector ).fileupload({
        url: '' + $( options.fileuploadSelector  ).attr( 'data-endpoint' ),
        type: 'POST',
        dropZone: null,
        fileInput: $( options.fileinputSelector  ),
        maxChunkSize: options.maxChunkSize,
        autoUpload: false,
        add: function ( e, data )
        {
            $( options.btnStartUploadSelector ).on( 'click', function ( e )
            {
                e.preventDefault();
                //e.stopPropagation();
                
                $( this ).hide();
                
                let submitForm  = true;
                if ( preFormSubmit ) {
                     submitForm = preFormSubmit();
                }
                
                let fileName    = data.files[0].name;
                if ( ! window.UploadedFiles.includes( fileName ) && submitForm ) {
                    //console.log( fileName );
                    window.UploadedFiles.push( fileName );
                    
                    data.submit();
                }
                
            });
        },
        formData: function ( form )
        {
            /*
             * Send Values Needed For PostPersistListener In Backend
             *
             * If Files is Not Wrapped by Form Name Remove It From Here
             */
            return postPersistFormData( form, options );
        }
    });
    
    $( options.fileuploadSelector ).on( 'fileuploadstart', function ( e, data )
    {
        $( options.progressbarSelector ).progressbar({
            value: 0,
            
            sizeUploaded: 0,
            sizeTotal: window.TestUploadProgressBarData.total,
            //text: "{sizeUploaded} / {sizeTotal} ( {value}% )"
        });
    });
    
    $( options.fileuploadSelector ).on( 'fileuploadprogress', function ( e, data )
    {
        //console.log( data.loaded, data.total, data.bitrate );
        var progressPercents    = Math.round( ( data.loaded / data.total ) * 100 );
        if ( progressPercents <= 100 ) {
            $( options.progressbarSelector ).progressbar( 'setValue', progressPercents );
        }
    });
    
    // Uncomment Console Logs For Debugging
    $( options.fileuploadSelector ).on( 'fileuploaddone', function ( e, data )
    {
        e.preventDefault();
        e.stopPropagation();
        
        //console.log( data );
        let result  = JSON.parse( data.result );
        if ( ! ( "resourceKey" in result ) ) {
            return;
        }
        
        $( options.progressbarSelector ).hide();
        
        /*
        console.log( 'jQueryFileUpload Debuging:' );
        console.log( data );
        console.log( data.result );
        */
        
        window.dispatchEvent(
            new CustomEvent( "resourceUploaded", {
                detail: {
                    resourceKey: result.resourceKey,
                    resourceId: result.resourceId
                },
            })
        );
    });
}

/**
 * USAGE:
 * ======
 *  TestUploadProgressBar({
 *      btnStartUploadSelector: "#btnSaveUploadFile",
 *      progressbarSelector: "#FileUploadProgressbar"
 *  });
 */
export function TestUploadProgressBar( options )
{
    $.extend( $.fn.progressbar.defaults, {
        sizeUploaded: 0,
        sizeTotal: 0
    });
    
    $( options.btnStartUploadSelector ).on( 'click', function ( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        if ( window.TestUploadProgressBarStarted ) {
            return;
        }
        window.TestUploadProgressBarStarted = true;
        $( options.progressbarSelector ).progressbar({
            value: 0,
            
            sizeUploaded: 0,
            sizeTotal: window.TestUploadProgressBarData.total,
            //text: "{sizeUploaded} / {sizeTotal} ( {value}% )"
        });
        
        for( let i = 1; i < 100; i++ ) {
            TestUploadProgress( i, $( options.progressbarSelector ) );
        }
    });
}

function TestUploadProgress( delayIndex, selector )
{
    setTimeout(() => {
        window.TestUploadProgressBarData.loaded = window.TestUploadProgressBarData.total / ( 100 - delayIndex );
        //console.log( window.TestUploadProgressBarData.loaded );
        
        var progressPercents    = Math.round( ( window.TestUploadProgressBarData.loaded / window.TestUploadProgressBarData.total ) * 100 );
        //console.log( progressPercents );
        
        if ( progressPercents <= 100 ) {
            selector.progressbar( 'setValue', progressPercents );
        }
    }, delayIndex * 3000);
}

function validateOptions( options )
{
    let requiredKeys = [
        'fileuploadSelector',
        'fileinputSelector',
        'btnStartUploadSelector',
        'progressbarSelector',
        'fileInputFieldName',
        'fileResourceId',
        'fileResourceKey',
        'fileResourceClass'
    ];
    
    if ( options.hasOwnProperty( 'requestType' ) && options.requestType == "VankosoftApi" ) {
        const index = requiredKeys.indexOf( 'fileResourceClass' );
        if ( index > -1 ) {
            requiredKeys.splice( index, 1 );
        }
    }
    
    let checkAllKeys = requiredKeys.every( ( i ) => options.hasOwnProperty( i ) );
    if( ! checkAllKeys ) {
        throw new Error( 'InitOneUpFileUpload has Missing Options !!!' );
    }
}

function postPersistFormData( form, options )
{
    //console.log( form );
    let formName    = form[0] ? form[0].name : '';
    let formData    = [
        {
            name: 'formName',
            value: formName
        },
        {
            name: 'fileInputFieldName',
            value: options.fileInputFieldName
        },
        {
            name: 'fileResourceId',
            value: options.fileResourceId
        },
        {
            name: 'fileResourceKey',
            value: options.fileResourceKey
        }
    ];
    
    if ( options.hasOwnProperty( 'requestType' ) && options.requestType == "VankosoftApi" ) {
        formData.push({
            name: 'requestType',
            value: options.requestType
        });
        formData.push({
            name: 'requestTarget',
            value: options.requestTarget
        });
        formData.push({
            name: 'fileOwnerId',
            value: options.fileOwnerId
        });
    } else {
        formData.push({
            name: 'fileResourceClass',
            value: options.fileResourceClass
        });
    }
    
    return formData;
}

function getFormFieldValue( form, field )
{
    if ( ! form[0] ) {
        return '';    
    }
    
    var formData = form.serializeArray();
    //console.log( formData );
    
    var myFieldName = form[0].name + '[' + field + ']';
    var myFieldFilter = function (field) {
        return field.name == myFieldName;
    }
    
    return formData.filter( myFieldFilter )[0].value;
}
