<?php

namespace Bazinga\JqueryUiBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * UiHelper
 * Contains a set of helper methods for jQuery UI.
 *
 * @package JqueryUiBundle
 * @subpackage Templating.Helper
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
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Default constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->router     = $container->get('router');
        $this->translator = $container->get('translator');
        $this->container  = $container;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
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
        return ('/' !== substr($routeOrUrl, 0, 1) && false === strpos($routeOrUrl, '://'));
    }

    /**
     * Returns a translated text.
     *
     * @param string|array $stringOrArray   A string or an array.
     * @param array $replace                An array of replacements.
     * @return string                       The translated text.
     */
    protected function translate($stringOrArray, $replace = array())
    {
        if (is_array($stringOrArray)) {
            $text = $this->translator->trans(current($stringOrArray), $replace, key($stringOrArray));
        } else {
            $text = $this->translator->trans($stringOrArray, $replace);
        }

        return $text;
    }

    /**
     * Parse options.
     *
     * @param array $options    An array of options.
     * @return array
     */
    protected function parseOptions($options)
    {
        // icons
        $icons = array('class' => null, 'primary' => null, 'secondary' => null);
        if (array_key_exists('icons', $options)) {
            if (isset($options['icons']['primary'])) {
                $icons['primary'] = $this->icon($options['icons']['primary'], 1);
                $icons['class'] = 'ui-button-text-icon-primary';
            }

            if (isset($options['icons']['secondary'])) {
                $icons['secondary'] = $this->icon($options['icons']['secondary'], 2);
                $icons['class'] = 'ui-button-text-icon-secondary';
            }

            if (null !== $icons['primary'] && null !== $icons['secondary']) {
                $icons['class'] = 'ui-button-text-icons';
            }
            unset($options['icons']);
        } else {
            $icons['class'] = 'ui-button-text-only';
        }

        // class parameter
        $additional_class = '';
        if (array_key_exists('class', $options)) {
            foreach ($options['class'] as $class) {
                $additional_class .= $class . ' ';
            }
            unset($options['class']);
        }

        // HTML options
        $html_options = '';
        if (array_key_exists('html', $options)) {
            foreach ($options['html'] as $k => $v) {
                $html_options .= $k . '="' . $v . '" ';
            }
            unset($options['html']);
        }

        return array($icons, trim($additional_class), trim($html_options));
    }

    /**
     * Renders a link tag.
     *
     * @param string $routeOrUrl    A route name or an URL (which begins with http... or /...).
     * @param string $text          The text to display on the link.
     * @param boolean $absolute     Whether the generated url should be absolute or relative (default: false).
     * @param boolean $autoDisabled Whether the link should be disabled (no link) or not (default: true).
     * @return string
     */
    public function link($routeOrUrl, $text, $absolute = false, $autoDisabled = true)
    {
        if ('' === $routeOrUrl) {
            $url = '';
        } else {
            if ($this->isRoute($routeOrUrl) && $routeOrUrl === $this->getRequest()->get('_route') && $autoDisabled) {
                return $this->translate($text);
            } else {
                $url = $this->isRoute($routeOrUrl) ? $this->router->generate($routeOrUrl, array(), $absolute) : $routeOrUrl;
            }
        }

        return strtr('<a href="%URL%">%TEXT%</a>', array('%URL%' => $url, '%TEXT%' => $this->translate($text)));
    }

    /**
     * Renders a simple button.
     *
     * Options:
     *      array(
     *          'icons' => array('primary' => '...', 'secondary' => '...'),
     *          'tag' => '...',
     *          'class' => array('...', '...'),
     *          'html' => array('xxx' => '...', 'zzz' => '...'),
     *      );
     *
     * @param string $text      A text to display on the button (label).
     * @param array $options    An array of options.
     * @return string
     */
    public function button($text, $options = array())
    {
        // tag parameter
        if (array_key_exists('tag', $options)) {
            $tag = $options['tag'];
            unset($options['tag']);
        } else {
            $tag = 'button';
        }

        list($icons, $additional_class, $html_options) = $this->parseOptions($options);

        if (array_key_exists('icon-only', $options) && true === $options['icon-only']) {
            if (null !== $icons['primary'] && null !== $icons['secondary']) {
                $icons['class'] = 'ui-button-icons-only';
            } else {
                $icons['class'] = 'ui-button-icon-only';
            }
        }

        return strtr(
            '<%TAG% class="ui-button ui-widget ui-state-default ui-corner-all %ADDITIONAL_CLASS%" %HTML_OPTIONS%>
                %ICON_PRIMARY%<span class="ui-button-text">%TEXT%</span>%ICON_SECONDARY%
            </%TAG%>', array(
                '%TAG%'              => $tag,
                '%HTML_OPTIONS%'     => trim($html_options),
                '%ADDITIONAL_CLASS%' => trim($additional_class . ' ' . $icons['class']),
                '%ICON_PRIMARY%'     => $icons['primary'],
                '%ICON_SECONDARY%'   => $icons['secondary'],
                '%TEXT%'             => $this->translate($text),
            ));
    }

    /**
     * Renders a button with a link.
     *
     * @param string $routeOrUrl    A route name or an URL (which begins with http... or /...).
     * @param string $text          The text to display on the button link.
     * @param array $options        An array of options.
     * @param boolean $absolute     Whether the generated url should be absolute or relative (default: false).
     * @param boolean $autoDisabled Whether the link should be disabled (no link) or not (default: true).
     * @return string
     */
    public function buttonLink($routeOrUrl, $text, $options = array(), $absolute = false, $autoDisabled = true)
    {
        // disable button
        if ($this->isRoute($routeOrUrl) && $routeOrUrl === $this->getRequest()->get('_route') && $autoDisabled) {
            if (array_key_exists('class', $options)) {
                $options['class'] = array_merge($options['class'], array('ui-state-disabled'));
            } else {
                $options['class'] = array('ui-state-disabled');
            }
        }
        // tag parameter
        if (array_key_exists('tag', $options)) {
            $tag = $options['tag'];
            unset($options['tag']);
        } else {
            $tag = 'button';
        }

        list($icons, $additional_class, $html_options) = $this->parseOptions($options);

        if (array_key_exists('icon-only', $options) && true === $options['icon-only']) {
            if (null !== $icons['primary'] && null !== $icons['secondary']) {
                $icons['class'] = 'ui-button-icons-only';
            } else {
                $icons['class'] = 'ui-button-icon-only';
            }
        }

        $linkText = strtr('%ICON_PRIMARY%<span class="ui-button-text">%TEXT%</span>%ICON_SECONDARY%',
            array(
                '%ICON_PRIMARY%'     => $icons['primary'],
                '%ICON_SECONDARY%'   => $icons['secondary'],
                '%TEXT%'             => $this->translate($text),
            ));

        return strtr(
            '<%TAG% class="ui-button ui-widget ui-state-default ui-corner-all %ADDITIONAL_CLASS%" %HTML_OPTIONS%>
                %LINK%
            </%TAG%>', array(
                '%TAG%'              => $tag,
                '%HTML_OPTIONS%'     => trim($html_options),
                '%ADDITIONAL_CLASS%' => trim($additional_class . ' ' . $icons['class']),
                '%LINK%'             => $this->link($routeOrUrl, $linkText, $absolute),
            ));
    }

    /**
     * Renders an info box.
     *
     * @param string $message   A message to display in the box.
     * @param string $replace   An array of replacements.
     * @param string $label     A label for this box (default: 'Info:').
     * @return string
     */
    public function infoBox($message, $replace = array(), $label = 'Info:')
    {
        return strtr(
            '<div class="ui-widget info-box">
                <div class="ui-state-highlight ui-corner-all" style="padding: 0 0.7em;">
                    <p>
                        <span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.7em;"></span>
                        <strong>%LABEL%</strong>
                        %MESSAGE%
                    </p>
                </div>
            </div>', array(
                '%MESSAGE%' => $this->translate($message, $replace),
                '%LABEL%'   => $this->translate($label, $replace),
            ));
    }

    /**
     * Renders an error box.
     *
     * @param string $message   A message to display in the box.
     * @param string $replace   An array of replacements.
     * @param string $label     A label for this box (default: 'Error:').
     * @return string
     */
    public function errorBox($message, $replace = array(), $label = 'Error:')
    {
        return strtr(
            '<div class="ui-widget error-box">
                <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                    <p>
                        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.7em;"></span>
                        <strong>%LABEL%</strong>
                        %MESSAGE%
                    </p>
                </div>
            </div>', array(
                '%MESSAGE%' => $this->translate($message, $replace),
                '%LABEL%'   => $this->translate($label),
            ));
    }

    /**
     * Renders an icon.
     *
     * Silk icons:
     *      This method supports **silk** icons (from famfamfam).
     *      Just prefix your icon name by 'silk-' to automatically use a
     *      silk icon instead of a JqueryUi one.
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
        // silk support
        if (0 === strpos($icon, 'silk')) {
            if (0 === $position) {
                $prefix = 'ui-silk ui-';
            } else {
                $prefix = 'ui-icon-silk ui-silk ui-';
            }
        } else {
            $prefix = 'ui-icon ui-icon-';
        }

        switch($position) {
            case 1: $suffix = 'ui-button-icon-primary';
                    break;
            case 2: $suffix = 'ui-button-icon-secondary';
                    break;
            default:
                    $suffix = '';
        }

        return strtr('<span class="%PREFIX%%ICON% %SUFFIX%"></span>',
            array(
                '%PREFIX%' => $prefix,
                '%ICON%' => $icon,
                '%SUFFIX%' => $suffix,
            ));
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
