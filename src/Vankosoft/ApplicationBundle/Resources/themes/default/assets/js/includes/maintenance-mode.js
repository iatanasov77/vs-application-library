window.MaintenanceModeStatus = 200;

export function CheckMaintenanceMode( url )
{
    $.ajax({
        type: "GET",
        url: url,        
        success: function( data, textStatus, xhr ) {
            console.log( xhr.status );
            alert( xhr.status );
            window.MaintenanceModeStatus = xhr.status;
        },
        complete: function( xhr, textStatus ) {
            console.log( xhr.status );
            alert( xhr.status );
            window.MaintenanceModeStatus = xhr.status;
        } 
    });
}