<?php

namespace Bazinga\JqueryUiBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

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

    public function __construct(\Symfony\Component\Routing\Router $router, \Symfony\Component\Translation\Translator $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
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
     * Renders a link tag.
     *
     * @param string $routeOrUrl   A route name or an URL (which begins with http... or /...).
     * @param string $text         The text to display on the link.
     * @param boolean $absolute    Whether the generated url should be absolute or relative (default: false).
     * @return string
     */
    public function link($routeOrUrl, $text, $absolute = false)
    {
        if ('/' === substr($routeOrUrl, 0, 1) || 0 === strpos($routeOrUrl, 'http')) {
            $url = $routeOrUrl;
        } else {
            $url = $this->router->generate($routeOrUrl, array(), $absolute);
        }

        return strtr(
            '<a href="%URL%">%TEXT%</a>', array('%URL%' => $url, '%TEXT%' => $this->translator->trans($text)));
    }

    /**
     * Renders a simple button.
     *
     * Options:
     *      array('icons' => array('primary' => '...', 'secondary' => '...'));
     *
     * @param string $text      A text to display on the button (label).
     * @param array $options    An array of options.
     * @return string
     */
    public function button($text, $options = array())
    {
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

        if (array_key_exists('tag', $options)) {
            $tag = $options['tag'];
        } else {
            $tag = 'button';
        }

        $html_options = '';
        if (array_key_exists('html', $options)) {
            foreach ($options['html'] as $k => $v) {
                $html_options .= $k . '="' . $v . '" ';
            }
        }

        return strtr(
            '<%TAG% class="ui-button ui-widget ui-state-default ui-corner-all %ADDITIONAL_CLASS%" %HTML_OPTIONS%>
                %ICON_PRIMARY%
                <span class="ui-button-text">%TEXT%</span>
                %ICON_SECONDARY%
            </%TAG%>', array(
                '%TAG%' => $tag,
                '%HTML_OPTIONS%' => $html_options,
                '%ADDITIONAL_CLASS%' => $additional_class,
                '%ICON_PRIMARY%' => $iconPrimary,
                '%TEXT%' => $text,
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
                '%MESSAGE%' => $this->translator->trans($message),
                '%LABEL%' => $this->translator->trans($label)
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
                '%MESSAGE%' => $this->translator->trans($message),
                '%LABEL%' => $this->translator->trans($label)
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
}
