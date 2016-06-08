/**
 * Thanks to Kenneth Truyers for his idea of how to implement namespaces in javascript
 *
 * @author https://www.kenneth-truyers.net/about-kenneth-truyers/
 * @see https://www.kenneth-truyers.net/2013/04/27/javascript-namespaces-and-modules/
 */

// create the root namespace and making sure we're not overwriting it
var CORE = CORE || {};

// create a general purpose namespace method
// this will allow us to create namespace a bit easier
CORE.createNS = function(namespace) {

    var nsparts = namespace.split(".");
    var parent = CORE;

    // we want to be able to include or exclude the root namespace
    // So we strip it if it's in the namespace
    if (nsparts[0] === "CORE") {
        nsparts = nsparts.slice(1);
    }

    // loop through the parts and create
    // a nested namespace if necessary
    for (var i = 0; i < nsparts.length; i++) {
        var partname = nsparts[i];
        // check if the current parent already has
        // the namespace declared, if not create it
        if (typeof parent[partname] === "undefined") {
            parent[partname] = {};
        }
        // get a reference to the deepest element
        // in the hierarchy so far
        parent = parent[partname];
    }
    // the parent is now completely constructed
    // with empty namespaces and can be used.
    return parent;
};

// Create the namespace for products
CORE.createNS("CORE.AJAX");
CORE.createNS("CORE.AJAX.COMMAND");

/**
 * Config
 */

CORE.AJAX.showLog = true;
CORE.AJAX.clickSelector = '*[data-ajax]';

/**
 * Ajax request handler
 */
CORE.AJAX.handler = function() {

    /**
     * Switch to enable/disabel debug output to console
     *
     * @var boolean
     */
    var flagToConsole = false;

    /**
     * Writes content to consoles log
     *
     * @param {mixed}
     *         content - The content to show in console
     * @param {string}
     *         method - Method to call on console
     */
    var toConsole = function(content, method) {

        if (method === undefined) {
            var method = 'log';
        }

        if (flagToConsole) {
            console[method](content);
        }
    };

    /**
     * Activates logoutput to console
     *
     * @param {boolean}
     *         flag - Flag to switch console output on or off
     */
    var showLog = function(flag) {
        flagToConsole = flag === true ? true : false;
    };

    /**
     * Parses json object and processes all DOM and ACT commands.
     *
     * @param {json}
     *         json - JSON with commands to process
     */
    var parseJson = function(json) {

        toConsole(json);

        jQuery.each(json, function(type, stack) {
            // DOM manipulations
            if (type == 'dom') {
                jQuery.each(stack, function(id, cmd) {
                    if (jQuery(id).length) {
                        jQuery.each(cmd, function(i, x) {
                            if (jQuery.isFunction(jQuery()[x.f])) {
                                return jQuery(id)[x.f](x.a);
                            }
                            toConsole('Unknown method/function "' + x.f + '"', 'error');
                        });
                        return;
                    }
                    toConsole('Selector "' + id + '" not found.', 'error');
                });
            }

            // Specific actions
            if (type == 'act') {
                jQuery.each(stack, function(i, cmd) {
                    switch (cmd.f) {
                        case "call" :
                            executeFunctionByName(cmd.a[0], window, cmd.a[1]);
                            break;
                        default :
                            executeFunctionByName(cmd.f, window, cmd.a);
                            break;
                    }
                });
            }
        });
    };

    /**
     * Thanks to skerit
     *
     * @author http://stackoverflow.com/users/233428/skerit
     * @see http://stackoverflow.com/a/6954277
     * @param {String}
     *         url - The current url
     * @param {String}
     *         paraMeterName - Name of Parameter to append
     * @param {Mixed}
     *         parameterValue - Value of parameter to append
     * @param {Boolean}
     *         atStart - Puts new parameter in front of all other parameters
     * @returns {String} - The url with appended parameter
     */
    var appendAjaxParameter = function(url, parameterName, parameterValue, atStart) {
        replaceDuplicates = true;
        if (url.indexOf('#') > 0) {
            var cl = url.indexOf('#');
            urlhash = url.substring(url.indexOf('#'), url.length);
        } else {
            urlhash = '';
            cl = url.length;
        }
        sourceUrl = url.substring(0, cl);

        var urlParts = sourceUrl.split("?");
        var newQueryString = "";

        if (urlParts.length > 1) {
            var parameters = urlParts[1].split("&");
            for (var i = 0; (i < parameters.length); i++) {
                var parameterParts = parameters[i].split("=");
                if (!(replaceDuplicates && (parameterParts[0] == parameterName))) {
                    if (newQueryString == "") {
                        newQueryString = "?";
                    } else {
                        newQueryString += "&";
                    }
                    newQueryString += parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
                }
            }
        }
        if (newQueryString == "") {
            newQueryString = "?";
        }

        if (atStart) {
            newQueryString = '?' + parameterName + "=" + parameterValue + (newQueryString.length > 1 ? '&' + newQueryString.substring(1) : '');
        } else {
            if (newQueryString !== "" && (newQueryString != '?')) {
                newQueryString += "&";
            }
            newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
        }
        return urlParts[0] + newQueryString + urlhash;
    };

    /**
     * Thanks to Jason Bunting
     *
     * @author http://stackoverflow.com/users/1790/jason-bunting
     * @see http://stackoverflow.com/a/359910
     */
    var executeFunctionByName = function(functionName, context) {

        var args = [].slice.call(arguments).splice(2);
        var namespaces = functionName.split(".");
        var func = namespaces.pop();

        for (var i = 0; i < namespaces.length; i++) {
            context = context[namespaces[i]];
        }

        return context[func].apply(context, args);
    };

    /**
     * Default errorhandler of ajax request
     */
    var requestErrorHandler = function(XMLHttpRequest, textStatus, errorThrown) {
        var errortext = XMLHttpRequest !== undefined ? XMLHttpRequest.responseText : 'Ajax Request Error: ' + textStatus;
        jQuery('body').prepend(errortext);
    };

    /**
     * Runs an ajax request with the ajaxOptions to provide
     *
     * @param {Object}
     *         ajaxOptions
     */
    var process = function(ajaxOptions) {

        if (ajaxOptions === undefined) {
            toConsole('Missing ajaxOptions. Aborting ajax.process()');
            return false;
        }

        // On success the response parser is called
        if (ajaxOptions.hasOwnProperty('success') === false) {
            ajaxOptions.success = parseJson;
        }

        // RETURNTYPE IS JSON
        if (ajaxOptions.hasOwnProperty('dataType') === false) {
            ajaxOptions.dataType = 'json';
        }

        // Add default error handler?
        if (ajaxOptions.hasOwnProperty('error') === false) {
            ajaxOptions.error = requestErrorHandler;
        }

        // Handle case when no request url exists
        if (ajaxOptions.url === false) {

            var errortext = '';

            switch (ajaxOptions.type) {
                case 'GET' :
                    errortext = 'Ajax GET: No URI to query found. Neither as "href", as "data-href" or "data-url". Aborting request.';
                    break;

                case 'POST' :
                    errortext = 'Ajax POST: No form action for submit found. Neither as "formaction" nor as "data-url", "data-href" from submitting button nor an "action" attribute from the form itself. Aborting request.';
                    break;
            }
            toConsole(errortext, 'error');
            return false;

        } else {
            // Append flag to give the processing script a hint that this is an
            // ajax driven request
            ajaxOptions.url = appendAjaxParameter(ajaxOptions.url, 'ajax', 1);
        }

        // Handle case wehn this is a POST request without data
        if ((ajaxOptions.type == 'POST') && ajaxOptions.data === false) {
            toConsole('Ajax POST: No form id to submit found. Neither as "form" nor as "data-form" attribute. Aborting request.', 'error');
            return false;
        }

        // Debug output of ajaxOptions object
        toConsole(ajaxOptions, 'debug');

        // Fire ajax request!
        jQuery.ajax(ajaxOptions);

        // Experimental pushState support für ajax requests
        if (ajaxOptions.type !== 'POST' && ajaxOptions.pushState === true) {
            history.pushState({}, '', ajaxOptions.url);
        }
    };

    return {
        process : process,
        showLog : showLog,
    };

};

/**
 * Generates ajax options from DOM element
 *
 * @param {Element}
 *         element - DOM Element to biuld options of
 * @returns {Object}
 */
CORE.AJAX.getAjaxOptions = function(element) {

    if (jQuery(element).data('ajax-options') !== undefined) {
        var ajaxOptions = jQuery(element).data('ajax-options')
    } else {
        var ajaxOptions = {};
    }

    var defaultOptions = {
        'url' : false,
        'type' : 'GET',
        'dataType' : 'json',
        'data' : false,
        'pushState' : true,
        'cache' : false
    };

    Object.keys(defaultOptions).forEach(function(key, index) {
        if (ajaxOptions.hasOwnProperty(key) === false) {
            ajaxOptions[key] = defaultOptions[key];
        }
    });

    // Which url to reqest? The data attribute "form"
    // indicates that we are going to send a
    // form. Without element, it is a normal link, that we are
    // going to load.

    if (jQuery(element).data('form') === undefined && jQuery(element).attr('form') === undefined) {

        // Try to get url either from links href attribute or
        switch (true) {
            case (jQuery(element).attr('href') !== undefined) :
                ajaxOptions.url = jQuery(element).attr('href');
                break;
            case (jQuery(element).data('href') !== undefined) :
                ajaxOptions.url = jQuery(element).data('href');
                break;
            case (jQuery(element).data('url') !== undefined) :
                ajaxOptions.url = jQuery(element).data('url');
                break;
        }

    } else {

        // Ext forms will be handled py POST
        ajaxOptions.type = 'POST';

        var id = false;

        // Get form id
        switch (true) {
            case (jQuery(element).attr('form') !== undefined) :
                id = jQuery(element).attr('form');
                break;

            case (jQuery(element).data('form') !== undefined) :
                id = jQuery(element).data('form');
                break;
        }

        // Since this is a form post, get the data to send to server
        if (id !== false) {
            ajaxOptions.data = jQuery('#' + id).serialize();
        }

        // Get action url
        switch (true) {
            case (jQuery(element).attr('formaction') !== undefined) :
                ajaxOptions.url = jQuery(element).attr('formaction');
                break;
            case (jQuery(element).data('href') !== undefined) :
                ajaxOptions.url = jQuery(element).data('href');
                break;
            case (jQuery(element).data('url') !== undefined) :
                ajaxOptions.url = jQuery(element).data('url');
                break;
            case (id !== false && jQuery('#' + id).attr('action') !== undefined) :
                ajaxOptions.url = jQuery('#' + id).attr('action');
                break;
        }
    }

    if (jQuery(this).data('no-state') !== undefined) {
        ajaxOptions.pushState = false;
    }

    return ajaxOptions;
};

/**
 * Action function to append an error to a specific selector
 *
 * @param {String}
 *         selector - Selector where to append error to
 * @param {String}
 *         error - Error to show
 */
CORE.AJAX.COMMAND.error = function(selector, error) {
    jQuery(selector).addClass('fade in').append('<p>' + error + '</p>');
    jQuery(selector).bind('closed.bs.alert', function() {
        jQuery(this).removeClass().empty().unbind('closed.bs.alert');
    });
};

/**
 * Bind click handler
 *
 * @param {Event}
 *         event - Clickevent
 * @returns {void}
 */
jQuery(document).on('click', CORE.AJAX.clickSelector, function(event) {

    event.preventDefault();

    if (jQuery(this).attr('data-confirm') !== undefined) {
        if (!confirm(jQuery(this).data('confirm'))) {
            return false;
        }
    }

    if (jQuery(this).attr('data-ajax') !== undefined) {

        var ajaxOptions = CORE.AJAX.getAjaxOptions(this);
        var ajax = new CORE.AJAX.handler();

        ajax.showLog(CORE.AJAX.showLog);
        ajax.process(ajaxOptions);
    }
});