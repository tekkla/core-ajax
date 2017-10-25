<?php
use Core\Ajax\Ajax;
use Core\Ajax\Commands\Dom\HtmlCommand;
use Core\Ajax\Commands\Act\AlertCommand;
use Core\Ajax\Commands\Act\ConsoleCommand;

// Require autoloader
require_once 'vendor/autoload.php';

// The javascript ajax handler appends 'ajax=1' as parameter to the requesturl to easily identify a request as ajax
if (isset($_GET['ajax'])) {

    // Get data from $_POST ...
    $data = $_POST['text'];

    if (!empty($_POST['text'])) {

        // ... and append the number of chars
        $data .= ' (Number of Chars: ' . strlen($data) . ')';
    }
    else {
        $data = 'Empty textarea sent.';
    }

    // Create new ajax processors
    $ajax = new Ajax();

    // HtmlCommand is php pendent to $('div#result').html($data)
    $ajax->addCommand(new HtmlCommand('div#result', $data));

    // AlertCommand is the php pendant to alert($data);
    $ajax->addCommand(new AlertCommand($data));

    // ConsoleCommand is the php pendant to console.log($data);
    $cmd = new ConsoleCommand($data);

    // Set function to console.info($data)
    $cmd->setLogType('info');

    // Add command to command stack
    $ajax->addCommand($cmd);

    // Send content type header
    header('Content-Type: application/json');

    // Echo json result
    echo $ajax->process();
    exit();
}

$example_own_events = '$(document).on("input", "#my-input", function() {
    var ajax = new CORE.AJAX.handler();
    ajax.process(CORE.AJAX.getAjaxOptions(this));
}';

$example_php = '&lt;?php
use Core\Ajax\Ajax;
use Core\Ajax\Commands\Dom\HtmlCommand;
use Core\Ajax\Commands\Act\AlertCommand;
use Core\Ajax\Commands\Act\ConsoleCommand;

// Require autoloader
require_once &quot;vendor/autoload.php&quot;;

// The javascript ajax handler appends &quot;ajax=1&quot; as parameter to the requesturl to easily identify a request as ajax
if (isset($_GET[&quot;ajax&quot;])) {

    // Get data from $_POST ...
    $data = $_POST[&quot;text&quot;];

    if (!empty($_POST[&quot;text&quot;])) {

        // ... and append the number of chars
        $data .= &quot; (Number of Chars: &quot; . strlen($data) . &quot;)&quot;;
    }
    else {
        $data = &quot;Empty textarea sent.&quot;;
    }

    // Create a new Core/Ajax processor
    $ajax = new Ajax();

    // HtmlCommand is php pendent to $(&quot;div#result&quot;).html($data)
    $ajax-&gt;addCommand(new HtmlCommand(&quot;div#result&quot;, $data));

    // AlertCommand is the php pendant to alert($data);
    $ajax-&gt;addCommand(new AlertCommand($data));

    // ConsoleCommand is the php pendant to console.log($data);
    $cmd = new ConsoleCommand($data);

    // Set function to console.info($data)
    $cmd-&gt;setLogType(&quot;info&quot;);

    // Add command to command stack
    $ajax-&gt;addCommand($cmd);

    // Send content type header
    header(&quot;Content-Type: application/json&quot;);

    // Echo json result
    echo $ajax-&gt;process();
    exit();
}?&gt;

&lt;html&gt;
&lt;head&gt;

&lt;!-- This lib needs jQuery --&gt;
&lt;script src=&quot;https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js&quot;&gt;&lt;/script&gt;

&lt;!-- Include  Core/Ajax handler--&gt;
&lt;script src=&quot;vendor/tekkla/core-ajax/Core/Ajax/Asset/core.ajax.js&quot;&gt;&lt;/script&gt;

&lt;!-- Bootstrap only for beautification --&gt;
&lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css&quot;&gt;&lt;/link&gt;
&lt;title&gt;Example: Core/Ajax&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class=&quot;container&quot;&gt;
        &lt;h3&gt;Input&lt;/h3&gt;
        &lt;p&gt;The content of textbox will sent by POST, the contents charcount appended to the text and the text sent to alert(), console.info() and div#result below the submit button.&lt;/p&gt;
        &lt;form id=&quot;testform&quot; method=&quot;post&quot; accept-charset=&quot;UTF-8&quot; action=&quot;example.php&quot;&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label for=&quot;text&quot;&gt;Enter a text or use the example text:&lt;/label&gt;&lt;br&gt;
                &lt;textarea class=&quot;form-control&quot; rows=&quot;10&quot; cols=&quot;80&quot; id=&quot;text&quot; name=&quot;text&quot;&gt;Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&lt;/textarea&gt;
            &lt;/div&gt;
            &lt;button class=&quot;form-control&quot; type=&quot;submit&quot; data-ajax form=&quot;testform&quot;&gt;Submit&lt;/button&gt;
        &lt;/form&gt;
        &lt;hr&gt;
        &lt;h3&gt;Target for HtmlCommand&lt;/h3&gt;
        &lt;div id=&quot;result&quot; class=&quot;well&quot;&gt;This text will be replaced with posted and processed content of textarea above.&lt;/div&gt;
    &lt;/div&gt;
&lt;/body&gt;

&lt;/html&gt;';

$general_data_attributes = [
    [
        'data-ajax <small>(no value neccessary)</small>',
        'Elements with this attribute will be bound to the Core/Ajax clickhandler which performs the ajax request. By default all ajax requests will be performed as GET.<br><strong>Note:</strong> The default clickevent will be prevented!'
    ],
    [
        'data-ajax-options="{json_encoded_options}"',
        'You can provide JSON encoded options as laying ground for the options that will be passed as settings into <code>$.ajax()</code>. Those options are the same as in <a href="http://api.jquery.com/jquery.ajax/#jQuery-ajax-settings">jQuery Ajax Settings</a> plus additional <code>pushState</code> (bool) to control the use of <code>history.pushState()</code>.'
    ],
    [
        'data-confirm="your_confirm_text"',
        'Prior to calling the request url by ajax the ajax clickhandler looks for this attribute and perfoms a <code>confirm(your_confirm_text)</code>. Denying the confirm will stop further processing of the clickevent.'
    ],
    [
        'data-no-state <small>(no value neccessary)</small>',
        'This lib comes with an experimental support of <code>history.pushState()</code>. By default all GET request urls will be added as pushstate. Setting this attribute will prevent this behaviour.'
    ]
];

$get_data_attributes = [
    [
        'href="your_request_handler.php"',
        'Most times an ajax request will be performed over a normal html link. So at first the value of <code>href</code> attribute will be searched for a request url. Only when this attribute does not exist the following <code>data</code> attributes will be searched for an url to use for request.'
    ],
    [
        'data-href="your_request_handler.php"',
        'This attributes is important when the ajax clickhandler has been bound to an element that does not or is not allowed to have a <code>href</code> attribute.'
    ],
    [
        'data-url="your_request_handler.php"',
        'Has the same function as <code>data-href</code> and exists only because of compatiblity reasons.'
    ]
];

$post_data_attributes = [
    [
        'form="your-form-id" <small>(applies only to button elements)</small>',
        'When using <code>button</code> elements as described above, the ajax clickhandler will POST the values of this form to the sever.'
    ],
    [
        'data-form="your-form-id"',
        'Has the same functionality as the <code>form</code> attribute and applies to all elements. Use this when you want to fire a POST clickevent from an element of your choice.'
    ],
    [
        'formaction="your_request_handler.php" <small>(applies only to button elements)</small>',
        'Applies to <code>button</code> elements too. This attributes value will be the request url.'
    ],
    [
        'data-href="your_request_handler.php"',
        'Use this attribute on elements that has no <code>formaction</code> attribute.'
    ],
    [
        'data-url="your_request_handler.php"',
        'Has the same function as <code>data-href</code> and exists only because of compatiblity reasons.'
    ]
];

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css"></link>
<link rel="stylesheet" href="prettify/prettify.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="vendor/tekkla/core-ajax/Core/Ajax/Asset/core.ajax.js"></script>
<script src="prettify/prettify.js"></script>
<title>Core/Ajax</title>
</head>
<body>
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Core/Ajax</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#installation">Installation</a></li>
                    <li><a href="#start">Start</a></li>
                    <li><a href="#attributes">Attributes</a></li>
                    <li><a href="#forms">Forms</a></li>
                    <li><a href="#example">Example</a></li>
                    <li><a href="#live">Live</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            <h1>Core/Ajax</h1>
            <p>A php/javascript library to perform an ajax request from any html element, handle it inside PHP and
                return a set of commands that will be parsed and executed in browser by javascript.</p>
            <p>This gives you the ability to perfom javascript actions from PHP side.</p>
        </div>
    </div>
    <div class="container">
        <h2 class="page-header" id="installation">Installation</h2>
        <p>The preferred installation method is composer.</p>
        <pre class="prettyprint">php composer.phar require tekkla/core-ajax</pre>
        <h3>Other requirements</h3>
        <ul>
            <li>
                <p>
                    The PHP part of this library needs at least <strong>PHP 7.0</strong>
                </p>
            </li>
            <li>
                <p>
                    The javascript part of this library needs jQuery. The libs js should work fine with every jQuery
                    version that supports
                    <code>$.ajax()</code>
                    The lib has been tested with jQuery 1.12.x.
                </p>
            </li>
        </ul>
        <h3>Core/Ajax Javascript</h3>
        <p>
            This library brings a javascript file that includes the Core/Ajax requesthandler. Load this file as every
            other js file but make sure that <strong>jQuery</strong> has been included before.
        </p>
        <p>
            You find the Core/Ajax requesthandler files in
            <code>\vendor\tekkla\core-ajax\Core\Ajax\Asset</code>
            . There you find an uncompressed and a minified version.
        </p>
        <h3>Compatibility</h3>
        <p>This library should work with all modern browsers.</p>
        <h2 class="page-header" id="start">An easy start</h2>
        <p>
            By default it's all about binding a clickevent to each element the has a
            <code>data-ajax</code>
            attribute. Clicking on such an element performs an ajax request with parameters either provided by normal or
            data attributes of this element.
        </p>
        <h6 class="panel-title">
            <small><strong>Example: Simple link</strong></small>
        </h6>
        <pre class="prettyprint">&lt;a data-ajax href=&quot;my_request_url.php&quot;&gt;My Link&lt;/a&gt;</pre>
        <p>Will perform a GET ajax request by using the value of the href-attribute as request url.</p>
        <h3>Custom Eventhandler</h3>
        <p>It's up to the developer to create own eventhandlers for own needs. By default this lib only supports
            clickevents.</p>
        <h6 class="panel-title">
            <small><strong>Example: Custom eventhandler</strong></small>
        </h6>
        <pre class="prettyprint"><?php echo $example_own_events; ?></pre>
        <h2 class="page-header" id="attributes">The Attributes</h2>
        <p>Several attributes are used to determine that has to and how the ajax request will be performed.</p>
        <h3>General Attributes</h3>
        <?php foreach ($general_data_attributes as $attr) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $attr[0]; ?></h3>
            </div>
            <div class="panel-body"><?php echo $attr[1]; ?></div>
        </div>
        <?php } ?>
        <h3>GET Attributes</h3>
        <?php foreach ($get_data_attributes as $attr) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $attr[0]; ?></h3>
            </div>
            <div class="panel-body"><?php echo $attr[1]; ?></div>
        </div>
        <?php } ?>

        <h2 class="page-header" id="forms">What about forms?</h2>
        <p>
            Usually you send data by defining a
            <code>&lt;input type=&quot;submit&quot;&gt;Submit&lt;/input&gt;</code>
            button. You simply can add the
            <code>data-ajax</code>
            and the
            <code>data-form=&quot;your-form-id&quot;</code>
            attribute and your form is Core/Ajax driven. The forms action attribute will be used as request url.
        </p>
        <h3>HTML5 buttons are cooler</h3>
        <p>
            With HTML5 it is possible to use a
            <code>button</code>
            element for submitting a form with a specified id and and an own formaction.
        </p>
        <p>
            I prefer to use
            <code>&lt;button type=&quot;submit&quot; form=&quot;your-form-id&quot;
                formaction=&quot;your_request_handler.php&quot;&gt;Submit&lt;/button&gt;</code>
            instead of the classic
            <code>&lt;input type=&quot;submit&quot;&gt;Submit&lt;/input&gt;</code>
            because of the flexibility to create and use multiple buttons for the same form, even outside of the forms
            context and with different formactions.
        </p>
        <p>
            With buttons it's the same way as with the classic input. Add the
            <code>data-ajax</code>
            and the
            <code>form="your-form-id"</code>
            attribute and your form is Core/Ajax driven. When attribute exists, the value of
            <code>formaction</code>
            attribute will be the request url. Without that the Core/Ajax clickhandler will look for a
            <code>data-url</code>
            attribute value before it falls back to the forms action attribute value.
        </p>
        <h3>POST Attributes</h3>
        <?php foreach ($post_data_attributes as $attr) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $attr[0]; ?></h3>
            </div>
            <div class="panel-body"><?php echo $attr[1]; ?></div>
        </div>
        <?php } ?>
        <h2 class="page-header" id="example">Example</h2>
        <p>
            1. Install Core/Ajax via composer as described above. (see <a href="#installation">Installation</a>)
        </p>
        <p>
            2. Create a file, name it
            <code>example.php</code>
            and copy the code below into it. That's it.
        </p>
        <pre class="prettyprint"><?php echo $example_php; ?></pre>
        <h2 class="page-header" id="live">
            <small>An example</small><br>Everything in action
        </h2>
        <p>The content of textbox below will be sent to the server by POST. On serverside the contents charcount will be
            appended to the content. The so processed content will be sent to alert(), console.info() and div#result
            below the submit button.</p>
        <form id="testform" method="post" accept-charset="UTF-8" action="index.php">
            <div class="form-group">
                <label for="text">Enter a text or use the example text:</label><br>
                <textarea class="form-control" rows="10" cols="80" id="text" name="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</textarea>
            </div>
            <button class="form-control" type="submit" data-ajax form="testform">Submit</button>
        </form>
        <hr>
        <h3>Target for HtmlCommand</h3>
        <div id="result" class="well">This text will be replaced with posted and processed content of textarea above.</div>

    </div>
    <div class="container">
        <hr>
        <p>
            <small>License MIT | Michael "Tekkla" Zorn | Copyright 2012-<?php echo date('Y'); ?> | <a
                href="https://github.com/Tekkla/core-ajax">@Github</a></small>
        </p>
    </div>
    <script>
  !function ($) {
    $(function(){
      window.prettyPrint && prettyPrint()
    })
  }(window.jQuery)
</script>
</body>
</html>
