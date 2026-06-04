require( 'jquery-ui-dist/jquery-ui.js' );
require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.theme.css' );

$( function()
{
    /*
     * Using JqueryUi Widget Factory
     */
    $.widget( "custom.widget", {
        // default options
        options: {
            callback: 'default-callback-url',
            afterLoad: null,
        },
 
        // The constructor
        _create: function() {
            var getCallbackUrl  = this.options.callback;
            var widgetContainer = this.element;
            var afterLoad       = this.options.afterLoad;
            
            $.ajax({
                type: "GET",
                url: getCallbackUrl,
                success: function( response )
                {
                    widgetContainer.html( response );
                    
                    if ( afterLoad ) {
                        afterLoad();
                    }
                },
                error: function()
                {
                    // alert( "AJAX WIDGET CALLBACK ERROR !!!" );
                    condole.log( "AJAX WIDGET CALLBACK ERROR !!!" );
                }
            });
        },
    });
});