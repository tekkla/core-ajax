/**
 * ajax.js
 * 
 * Namespace: CORE.AJAX
 * 
 * @author Michael Zorn <tekkla@tekkla.de>
 * @copyright 2012-2017
 * @license MIT
 */

// Used namespaces
CORE.createNS("CORE.AJAX");
CORE.createNS("CORE.AJAX.COMMAND");

/**
 * Events which should be bound on elements
 * 
 * @var string
 * @default 'click'
 */
CORE.AJAX.clickEvents = 'click';

/**
 * Elements with this selector to bind clickevents on
 * 
 * @var string
 * @default '*[data-ajax]
 */
CORE.AJAX.clickSelector = '*[data-ajax]';

/**
 * Default target to run DOM action on when the selector inside the DOM action
 * not found
 * 
 * @var string
 * @default 'body'
 */
CORE.AJAX.defaultTarget = 'body';

/**
 * Default target to run DOM action on when the selector inside the DOM action
 * not found
 * 
 * @var string
 * @default '#core-message'
 */
CORE.AJAX.errorTarget = '#core-message';

/**
 * Flag to activate console output for debugging
 * 
 * @var boolean
 * @default false
 */
CORE.AJAX.showLog = false;

/**
 * Callback functions to call after
 * 
 * @var array
 * @default []
 */
CORE.AJAX.callbacks = [];

/**
 * The Ajax request handler
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
     *            content - The content to show in console
     * @param {string}
     *            method - Method to call on console
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
     *            flag - Flag to switch console output on or off
     */
    var showLog = function(flag) {
        flagToConsole = flag === true ? true : false;
    };

    /**
     * Parses json object and processes all DOM and ACT commands.
     * 
     * @param {json}
     *            json - JSON with commands to process
     */
    var parseJson = function(json) {

        toConsole(json);

        jQuery.each(json, function(type, stack) {
            // DOM manipulations
            if (type == 'dom') {
                jQuery.each(stack, function(selector, cmd) {

                    // Check selector exits in dom and use default selector if
                    // not
                    if (!jQuery(selector).length) {

                        var consoleText = 'Selector "' + selector + '" not found.';

                        selector = CORE.AJAX.defaultTarget;

                        consoleText += ' Using default target "' + selector + '" instead.';

                        toConsole(consoleText, 'error');
                    }

                    jQuery.each(cmd, function(i, x) {
                        if (jQuery.isFunction(jQuery()[x.f])) {
                            return jQuery(selector)[x.f](x.a);
                        }
                        toConsole('Unknown method/function "' + x.f + '"', 'error');
                    });
                    return;

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
     * Appends a parameter to an url. Thanks to skerit.
     * 
     * @author http://stackoverflow.com/users/233428/skerit
     * @see http://stackoverflow.com/a/6954277
     * @param {String}
     *            url - The current url
     * @param {String}
     *            paraMeterName - Name of Parameter to append
     * @param {Mixed}
     *            parameterValue - Value of parameter to append
     * @param {Boolean}
     *            atStart - Puts new parameter in front of all other parameters
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
                if (!(replaceDuplicates && (((parameterParts[0] == parameterName))))) {
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
            if (newQueryString !== "" && (((newQueryString != '?')))) {
                newQueryString += "&";
            }
            newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
        }
        return urlParts[0] + newQueryString + urlhash;
    };

    /**
     * Removes as parameter from an url
     * 
     * @param {string}
     *            url - The url
     * @param {string}
     *            parameterName - Name of parameter to remove
     * @return {string}
     */
    var removeAjaxParameter = function(url, parameterName) {

        var urlparts = url.split('?');

        if (urlparts.length >= 2) {
            var urlBase = urlparts.shift();
            var queryString = urlparts.join("?");
            var prefix = encodeURIComponent(parameterName) + '=';
            var pars = queryString.split(/[&;]/g);
            for (var i = pars.length; i-- > 0;) {
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }
            url = urlBase + (pars.length > 1 ? '?' + pars.join('&') : '');
        }
        return url;
    };

    /**
     * Thanks to Jason Bunting
     * 
     * @author http://stackoverflow.com/users/1790/jason-bunting
     * @see http://stackoverflow.com/a/359910
     */
    var executeFunctionByName = function(functionName, context) {

        var args = null;

        if (Object.prototype.toString.call(arguments[2]) !== '[object Array]') {
            args = Array.prototype.slice.call(arguments, 2);
        } else {
            args = arguments[2];
        }

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

        jQuery(CORE.AJAX.errorTarget || CORE.AJAX.defaultTarget).html(errortext);
    };

    /**
     * Runs an ajax request with the ajaxOptions to provide
     * 
     * @param {Object}
     *            ajaxOptions
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
        }

        var requestUrl = ajaxOptions.url;

        // Append flag to give the processing script a hint that this is an
        // ajax driven request
        ajaxOptions.url = appendAjaxParameter(requestUrl, 'ajax', 1);

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
        if (ajaxOptions.type !== 'POST' && ajaxOptions.pushState !== false) {
            history.pushState(requestUrl, '', requestUrl);
        }
    };

    return {
        process : process,
        showLog : showLog,
    };

};

/**
 * Registers a callback function that will be called at the end of
 * CORE.AJAX.handler()
 * 
 * @param {Function}
 *            Function to be called
 */
CORE.AJAX.registerCallback = function(callback) {
    CORE.AJAX.callbacks.push(callback);
};

/**
 * Execute registered callbacks
 */
CORE.AJAX.executeCallbacks = function() {
    for (i = 0; i < CORE.AJAX.callbacks.length; i++) {
        CORE.AJAX.callbacks[i]();
    }
}

/**
 * Generates ajax options from DOM element
 * 
 * @param {Element}
 *            element to get the ajax options from
 * @returns {Object}
 */
CORE.AJAX.getAjaxOptions = function(element) {

    var ajaxOptions = {};

    if (jQuery(element).data('ajax')) {
        ajaxOptions = jQuery(element).data('ajax');
    } else if (jQuery(element).data('ajax-options') !== undefined) {
        ajaxOptions = jQuery(element).data('ajax-options');
    }

    var defaultOptions = {
        'url' : false,
        'type' : 'GET',
        'dataType' : 'json',
        'data' : false,
        'pushState' : true,
        'cache' : false,
    };

    Object.keys(defaultOptions).forEach(function(key, index) {
        if (ajaxOptions.hasOwnProperty(key) === false) {
            ajaxOptions[key] = defaultOptions[key];
        }
    });

    // Try to find requesturl only when there is nome set in ajaxOptions
    if ((ajaxOptions.url == false) || (ajaxOptions.url.length == 0)) {

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
    }

    if (jQuery(element).data('no-state') !== undefined) {
        ajaxOptions.pushState = false;
    }

    return ajaxOptions;
};

/**
 * Action function to append an error to a specific selector
 * 
 * @param {String}
 *            selector - Selector where to append error to
 * @param {String}
 *            error - Error to show
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
 *            event - Clickevent
 * @returns {void}
 */
jQuery(document).on(CORE.AJAX.clickEvents, CORE.AJAX.clickSelector, function(event) {

    event.preventDefault();

    if (jQuery(this).attr('data-confirm') !== undefined) {
        if (!confirm(jQuery(this).data('confirm'))) {
            return false;
        }
    }

    var ajaxOptions = CORE.AJAX.getAjaxOptions(this);
    var ajax = new CORE.AJAX.handler();

    ajax.showLog(CORE.AJAX.showLog);
    ajax.process(ajaxOptions);
});

/**
 * Execute registered callbacks on end of ajax request
 * 
 * @returns {void}
 */
jQuery(document).on("ajaxComplete", function() {
    CORE.AJAX.executeCallbacks();
});

/**
 * Popstate history handling
 */

// Store the initial content so we can revisit it later
jQuery(window).on("load", function() {
    history.replaceState(document.location.href, document.title, document.location.href);
});

/**
 * Processes popState event
 */
jQuery(window).on("popstate", function(e) {

    var ajax = new CORE.AJAX.handler();

    ajax.showLog(CORE.AJAX.showLog);
    ajax.process({
        url : e.originalEvent.state !== undefined ? e.originalEvent.state : location.href,
        pushState : false
    });

    // Run registered callbacks
    CORE.AJAX.executeCallbacks();

});
