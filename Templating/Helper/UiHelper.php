<?php

namespace Bazinga\JqueryUiBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * UiHelper
 * Contains a set of helper methods for jQuery UI.
 *
 * @author William DURAND <william.durand1@gmail.com>
 */
class UiHelper extends Helper
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;
    /**
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Default constructor.
     *
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->router = $container->get('router');
        $this->translator = $container->get('translator');
        $this->request = $container->get('request');
    }

    /**
     * Getter.
     *
     * @return string   The name of this helper.
     */
    public function getName()
    {
        return 'jquery_ui';
    }

    /**
     * Check if a string is a route name or not.
     *
     * @param string $routeOrUrl    A route or an URL
     * @return boolean              Whether the parameter is a real route name or not.
     */
    protected function isRoute($routeOrUrl)
    {
        return ('/' !== substr($routeOrUrl, 0, 1) && 0 !== strpos($routeOrUrl, 'http'));
    }

    /**
     * Returns a translated text.
     *
     * @param string|array $stringOrArray    A string or an array.
     * @return string   The translated text.
     */
    protected function translate($stringOrArray)
    {
        if (is_array($stringOrArray)) {
            $text = $this->translator->trans(current($stringOrArray), array(), key($stringOrArray));
        } else {
            $text = $this->translator->trans($stringOrArray);
        }

        return $text;
    }

    /**
     * Renders a link tag.
     *
     * @param string $routeOrUrl   A route name or an URL (which begins with http... or /...).
     * @param string $text         The text to display on the link.
     * @param boolean $absolute    Whether the generated url should be absolute or relative (default: false).
     * @return string
     */
    public function link($routeOrUrl, $text, $absolute = false)
    {
        if ('' === $routeOrUrl) {
            $url = '';
        } else {
            $url = $this->isRoute($routeOrUrl) ? $this->router->generate($routeOrUrl, array(), $absolute) : $routeOrUrl;
        }

        return strtr(
            '<a href="%URL%">%TEXT%</a>', array('%URL%' => $url, '%TEXT%' => $this->translate($text)));
    }

    /**
     * Renders a simple button.
     *
     * Options:
     *      array(
     *          'icons' => array('primary' => '...', 'secondary' => '...'),
     *          'tag' => '...',
     *          'class' => array('...', '...'),
     *          'html_options' => array('xxx' => '...', 'zzz' => '...'),
     *      );
     *
     * @param string $text      A text to display on the button (label).
     * @param array $options    An array of options.
     * @return string
     */
    public function button($text, $options = array())
    {
        // FIXME: Refactor the following part.

        // icons parameter
        if (array_key_exists('icons', $options)) {
            if (isset($options['icons']['primary'])) {
                $iconPrimary = $this->icon($options['icons']['primary'], 1);
                $additional_class = 'ui-button-text-icon-primary';
            } else {
                $iconPrimary = '';
            }

            if (isset($options['icons']['secondary'])) {
                $iconSecondary = $this->icon($options['icons']['secondary'], 2);
                $additional_class = 'ui-button-text-icon-secondary';
            } else {
                $iconSecondary = '';
            }

            if ('' === $iconPrimary && '' === $iconSecondary) {
                $additional_class = 'ui-button-text-icons';
            }
        } else {
            $iconPrimary = '';
            $iconSecondary = '';
            $additional_class = 'ui-button-text-only';
        }

        // tag parameter
        if (array_key_exists('tag', $options)) {
            $tag = $options['tag'];
        } else {
            $tag = 'button';
        }

        // class parameter
        if (array_key_exists('class', $options)) {
            foreach ($options['class'] as $class) {
                $additional_class .= ' ' . $class;
            }
        }

        // HTML options
        $html_options = '';
        if (array_key_exists('html', $options)) {
            foreach ($options['html'] as $k => $v) {
                $html_options .= $k . '="' . $v . '" ';
            }
        }

        return strtr(
            '<%TAG% class="ui-button ui-widget ui-state-default ui-corner-all %ADDITIONAL_CLASS%" %HTML_OPTIONS%>
                %ICON_PRIMARY%<span class="ui-button-text">%TEXT%</span>%ICON_SECONDARY%
            </%TAG%>', array(
                '%TAG%' => $tag,
                '%HTML_OPTIONS%' => $html_options,
                '%ADDITIONAL_CLASS%' => $additional_class,
                '%ICON_PRIMARY%' => $iconPrimary,
                '%TEXT%' => $this->translate($text),
                '%ICON_SECONDARY%' => $iconSecondary,
            ));
    }

    /**
     * Renders a button with a link.
     *
     * @param string $routeOrUrl   A route name or an URL (which begins with http... or /...).
     * @param string $text         The text to display on the button link.
     * @param array $options       An array of options.
     * @param boolean $absolute    Whether the generated url should be absolute or relative (default: false).
     * @return string
     */
    public function buttonLink($routeOrUrl, $text, $options = array(), $absolute = false)
    {
        if ($this->isRoute($routeOrUrl) && $routeOrUrl == $this->request->get('_route')) {
            if (array_key_exists('class', $options)) {
                $options['class'] = array_merge($options['class'], array('ui-state-disabled'));
            } else {
                $options['class'] = array('ui-state-disabled');
            }
        }

        return $this->button($this->link($routeOrUrl, $text, $absolute), $options);
    }

    /**
     * Renders an info box.
     *
     * @param string $message   A message to display in the box.
     * @param string $label     A label for this box (default: 'Info:').
     * @return string
     */
    public function infoBox($message, $label = 'Info:')
    {
        return strtr(
            '<div class="ui-widget info-box">
                <div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;">
                    <p>
                        <span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em; margin-top: 0.1em;"></span>
                        <strong>%LABEL%</strong>
                        %MESSAGE%
                    </p>
                </div>
            </div>', array(
                '%MESSAGE%' => $this->translate($message),
                '%LABEL%' => $this->translate($label),
            ));
    }

    /**
     * Renders an error box.
     *
     * @param string $message   A message to display in the box.
     * @param string $label     A label for this box (default: 'Error:').
     * @return string
     */
    public function errorBox($message, $label = 'Error:')
    {
        return strtr(
            '<div class="ui-widget error-box">
                <div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
                    <p>
                        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.1em;"></span>
                        <strong>%LABEL%</strong>
                        %MESSAGE%
                    </p>
                </div>
            </div>', array(
                '%MESSAGE%' => $this->translate($message),
                '%LABEL%' => $this->translate($label),
            ));
    }

    /**
     * Renders an icon.
     *
     * Positions:
     *      0: none (default).
     *      1: primary.
     *      2: secondary.
     *
     * @param string $icon      An icon name.
     * @param integer $position Icon position.
     * @return string
     */
    public function icon($icon, $position = 0)
    {
        switch($position) {
            case 1: $prefix = 'ui-button-icon-primary';
                    break;
            case 2: $prefix = 'ui-button-icon-secondary';
                    break;
            default:
                    $prefix = '';
        }

        $icon_class = sprintf('%s ui-icon ui-icon-%s', $prefix, $icon);

        return strtr('<span class="%ICON_CLASS%"></span>', array('%ICON_CLASS%' => $icon_class));
    }

    /**
     * Renders a 'submit' button.
     *
     * @param string $text         The text to display on the button.
     * @param array $options       An array of options.
     * @return string
     */
    public function submit($text, $options = array())
    {
        if (array_key_exists('html', $options)) {
            $options['html'] = array_merge($options['html'], array('type' => 'submit'));
        } else {
            $options['html'] = array('type' => 'submit');
        }

        return $this->button($text, $options);
    }
}
