JqueryUiBundle
==============

Here is a set of Twig functions and PHP helpers for [jQuery UI](http://jqueryui.com/).
You will be able to display degraded versions of buttons, messages box and icons.
This bundle *does not* provide assets like javascripts or stylesheets files to be able to use your own dependencies.


Installation
------------

* Install this bundle as usual.

* Add the following line to `app/config/config.yml`:

> bazinga_jquery_ui: ~

* Don't forget to add _jQuery/jQuery UI assets_ (javascript, css) as this bundle does not contains these files.

* You are ready.


Usage (Twig)
------------

### jui_link

Simple function to display links by using a route name, a relative URL or an absolute URL.

    {{ jui_link('homepage', 'home') }}
    <a href="/app_dev.php/">home</a>

    {{ jui_link('/toto', 'toto') }}
    <a href="/toto">toto</a>

    {{ jui_link('http://google.fr', 'Google') }}
    <a href="http://google.fr">Google</a>


### jui_button

Display a jQuery UI button.

    {{ jui_button('hello') }}
    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
        <span class="ui-button-text">hello</span>
    </button>

You can add (standard)  *icons*:

    {{ jui_button('configuration', {'icons': { 'primary': 'wrench', 'secondary': 'tag'} }) }}
    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-secondary">
        <span class="ui-button-icon-primary ui-icon ui-icon-wrench"></span>
        <span class="ui-button-text">configuration</span>
        <span class="ui-button-icon-secondary ui-icon ui-icon-tag"></span>
    </button>

    {{ jui_button('configuration', {'icons': { 'primary': 'wrench'} }) }}
    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">
        <span class="ui-button-icon-primary ui-icon ui-icon-wrench"></span>
        <span class="ui-button-text">configuration</span>
    </button>

Available options:

    // Icons to add (primary is on the left, secondary on the right)
    'icons': { 'primary': '...', 'secondary': '...' }

    // Tag to render (default: button)
    'tag': '...'

    // HTML options to add in the tag element (e.g. <button id="..." name="...">)
    'html': { 'id': '...', 'name': '...' }

    // CSS class
    'class': [ '...', '...', ... ]


### jui_button_link

Combine a button with a link.

    {{ jui_button_link('homepage', 'hello', {'icons': {'primary': 'wrench'}} ) }}

    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">
        <span class="ui-button-icon-primary ui-icon ui-icon-wrench"></span>
        <span class="ui-button-text"><a href="/app_dev.php/">hello</a></span>
    </button>


### jui_info_box

Display information messages:

    {{ jui_info_box('Hello world !') }}
    <div class="ui-widget info-box">
        <div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;">
            <p>
                <span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em; margin-top: 0.1em;"></span>
                <strong>Info:</strong>
                Hello world !
            </p>
        </div>
    </div>

### jui_error_box

Display error messages:

    {{ jui_error_box('Warning !') }}
    <div class="ui-widget error-box">
        <div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
            <p>
                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.1em;"></span>
                <strong>Warn:</strong>
                Warning !
            </p>
        </div>
    </div>


### jui_icon

Display a (standard) icon:

    {{ jui_icon('tag') }}
    <span class=" ui-icon ui-icon-tag"></span>


Usage (PHP)
-----------

...


Translations
------------

Each `text` parameter can use translation.
You can pass a simple key as a string (e.g. 'my.big.title). It will translate this key by using the default catalogue.

You can specify your own message catalogue by using this syntax:

    { 'MyCatalogue' : 'my.big.title' }


Credits
-------

* William DURAND (Bazinga) as main author.
* Julien MUETTON (Carpe Hora) for the inspiration.
