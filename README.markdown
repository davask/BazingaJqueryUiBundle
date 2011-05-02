JqueryUiBundle
==============

Here is a set of Twig functions and PHP helpers for [jQuery UI](http://jqueryui.com/).

**Why ?** You will be able to display degraded versions of buttons, messages box and icons. That ensures to get the same render with and without JavaScript on the most part of web browsers.

_Note:_ This bundle *does not* provide assets like javascripts or stylesheets files to be able to use your own dependencies.


Installation
------------

Install this bundle as usual:

> git submodule add git://github.com/Bazinga/JqueryUiBundle.git vendor/bundles/Bazinga/JqueryUiBundle

Register the namespace in `app/autoload.php`:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Bazinga' => __DIR__.'/../vendor/bundles',
    ));

Register the bundle in `app/AppKernel.php`:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Bazinga\JqueryUiBundle\BazingaJqueryUiBundle(),
        );
    }

Add the following line to `app/config/config.yml`:

> bazinga_jquery_ui: ~

Don't forget to add _jQuery/jQuery UI assets_ (javascript, css) as this bundle does not contains these files.

You are ready.


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

    {{ jui_link('my_route', 'Absolute link', true) }}
    <a href="http://myapp/my_route">Absolute link</a>

By default, a route will generate a relative URL. By setting the third parameter to `true`, you will generate absolute URLs.

By default, the helper tries to match the current route with the route in parameter. If both match, the link will be _disabled_.
That means there will be no link. To force the link, you can set the fourth parameter (`autoDisabled`) to `false`.


### jui_button

Display a jQuery UI button.

    {{ jui_button('hello') }}
    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
        <span class="ui-button-text">hello</span>
    </button>

You can add (standard) *icons*:

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

It combines both parameters of `jui_button()` and `jui_link()`.


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


You can use _placeholders_ by using the following syntax:

    {{ jui_info_box('Hello %name%', {'%name%' : 'world' }) }}
    <div class="ui-widget info-box">
        <div class="ui-state-highlight ui-corner-all" style="padding: 0 0.7em;">
            <p>
                <span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.7em;"></span>
                <strong>Info:</strong>
                Hello world
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


You can also use _placeholders_.


### jui_icon

Display a (standard) icon:

    {{ jui_icon('tag') }}
    <span class=" ui-icon ui-icon-tag"></span>


### jui_submit

Display a _submit_ button:

    {{ jui_submit({ 'AdminBundle' : 'btn_batch' }) }}
    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" >
        <span class="ui-button-text">Ok</span>
    </button>


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
