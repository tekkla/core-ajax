
var coreAjax = {

    loadAjax : function(element, callback, ajaxOptions) {

        if (ajaxOptions === undefined) {
            var ajaxOptions = {};
        }

        // On success the response parser is called
        if (ajaxOptions.hasOwnProperty('success') === false) {
            ajaxOptions.success = this.parseJSON;
        }

        // RETURNTYPE IS JSON
        if (ajaxOptions.hasOwnProperty('dataType') === false) {
            ajaxOptions.dataType = 'json';
        }

        // Which url to reqest? The data attribute "form"
        // indicates that we are going to send a
        // form. Without this, it is a normal link, that we are
        // going to load.
        if ($(element).data('form') === undefined && $(element).attr('form') === undefined) {

            // Ext links will be handled by GET
            ajaxOptions.type = 'GET';

            // Try to get url either from links href attribute or
            if ($(element).attr('href') !== undefined) {
                var url = $(element).attr('href');
            } else if ($(element).data('href') !== undefined) {
                var url = $(element).data('href');
            } else if ($(element).data('url') !== undefined) {
                var url = $(element).data('url');
            } else {
                console.log('Ajax GET: No URI to query found. Neither as "href", as "data-href" or "data-url". Aborting request.');
                return false;
            }
        } else {

            // Ext forms will be handled py POST
            ajaxOptions.type = 'POST';

            // Get form id
            switch (true) {
                case ($(element).attr('form') !== undefined):
                    var id = $(element).attr('form');
                    break;

                case ($(element).data('form') !== undefined):
                    var id = $(element).data('form');
                    break;
                default:
                    console.log('Ajax POST: No form id to submit found. Neither as "form" nor as "data-form" attribute. Aborting request.');
                    return false;
            }

            // Get action url
            switch (true) {
                case ($(element).attr('formaction') !== undefined):
                    var url = $(element).attr('formaction');
                    break;
                case ($(element).data('url') !== undefined):
                    var url = $(element).data('url');
                    break;
                case ($(element).data('href') !== undefined):
                    var url = $(element).data('href');
                    break;
                case ($('#' + id).attr('action') !== undefined):
                    var url = $('#' + id).attr('action');
                    break;
                default:
                    console.log('Ajax POST: No form action for submit found. Neither as "formaction" nor as "data-url", "data-href" or "action" attribute from the form itself. Aborting request.');
                    return false;
            }

            // Since this is a form post, get the data to send to
            // server
            ajaxOptions.data = $('#' + id).serialize();
        }

        // Set the url to use
        ajaxOptions.url = url + '/ajax';

        // Add error handler
        ajaxOptions.error = function(XMLHttpRequest, textStatus, errorThrown) {
            var errortext = XMLHttpRequest !== undefined ? XMLHttpRequest.responseText : 'Ajax Request Error: ' + textStatus;
        };

        // Fire ajax request!
        $.ajax(ajaxOptions);

        if (ajaxOptions.type !== 'POST' && $(element).data('nostate') === undefined) {
            history.pushState({}, '', url);
        }

        if (callback !== undefined) {
            callback();
        }

        return this;
    },

    // ----------------------------------------------------------------------------
    // Json parser for Ext ajax response
    // ----------------------------------------------------------------------------
    parseJSON : function(json) {

        $.each(json, function(type, stack) {

            // DOM manipulations
            if (type == 'dom') {
                $.each(stack, function(id, cmd) {

                    if ($(id).length) {

                        $.each(cmd, function(i, x) {

                            if (jQuery.isFunction($()[x.f])) {
                                selector = $(id)[x.f](x.a);
                            } else {
                                console.log('Unknown method/function "' + x.f + '"');
                            }
                        });

                    } else {
                        console.log('Selector "' + id + '" not found.');
                    }
                });
            }

            // Specific actions
            if (type == 'act') {
                $.each(stack, function(i, cmd) {
                    switch (cmd.f) {
                        case "error":
                            $(cmd.a[0]).addClass('fade in').append('<p>' + cmd.a[1] + '</p>');
                            $(cmd.a[0]).bind(
                                    'closed.bs.alert',
                                    function() {
                                        $(this).removeClass().html('').unbind('closed.bs.alert');
                                    });
                            break;
                        case 'getScript':
                            $.getScript(cmd.a);
                            break;
                        case 'href':
                            window.location.href = cmd.a;
                            return;
                        default:
                            [cmd.f](cmd.a);
                            break;
                    }
                });
            }
        });

        coreFw.readyAndAjax();
    }
}

$(document).on('click', '*[data-confirm], *[data-ajax]', function(event) {

    if ($(this).attr('data-confirm') !== undefined) {

        if (!confirm($(this).data('confirm'))) {
            event.preventDefault();
            return false;
        }
    }

    if ($(this).attr('data-ajax') !== undefined) {
        coreAjax.loadAjax(this);
        event.preventDefault();
    }

});