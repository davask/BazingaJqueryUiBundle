<?php

namespace Bazinga\JqueryUiBundle\Twig\Extension;

use Bazinga\JqueryUiBundle\Templating\Helper\UiHelper;

/**
 * UiExtension
 * Twig extension for the UiHelper class.
 *
 * @author William DURAND <william.durand1@gmail.com>
 */
class UiExtension extends \Twig_Extension
{
    /**
     * @var UiHelper
     */
    protected $helper;

    /**
     * Default constructor.
     *
     * @param UiHelper  A UiHelper instance.
     */
    public function __construct(UiHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Getter.
     *
     * @return string   The name of this extension.
     */
    public function getName()
    {
        return $this->helper->getName();
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'jui_link'          => new \Twig_Function_Method($this, 'link',         array('is_safe' => array('html'))),
            'jui_button'        => new \Twig_Function_Method($this, 'button',       array('is_safe' => array('html'))),
            'jui_button_link'   => new \Twig_Function_Method($this, 'buttonLink',   array('is_safe' => array('html'))),
            'jui_info_box'      => new \Twig_Function_Method($this, 'infoBox',      array('is_safe' => array('html'))),
            'jui_error_box'     => new \Twig_Function_Method($this, 'errorBox',     array('is_safe' => array('html'))),
            'jui_icon'          => new \Twig_Function_Method($this, 'icon',         array('is_safe' => array('html'))),
            'jui_submit'        => new \Twig_Function_Method($this, 'submit',       array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a link tag.
     *
     * Example:
     *      {{ jui_link('homepage', 'Home', false) }}
     *
     * @param string $routeOrUrl    A route name or an URL (which begins with http... or /...).
     * @param string $text          The text to display on the link.
     * @param boolean $absolute     Whether the generated url should be absolute or relative (default: false).
     * @param boolean $autoDisabled Whether the link should be disabled (no link) or not (default: true).
     * @return string
     */
    public function link($route, $text, $absolute = false, $autoDisabled = true)
    {
        return $this->helper->link($route, $text, $absolute, $autoDisabled);
    }

    /**
     * Renders a simple button.
     *
     * Example:
     *      {{ jui_button('Hello') }}
     *      {{ jui_button('Configuration', {'icons': { 'primary': 'wrench'} }) }}
     *
     * Options:
     *      {
     *          'icons': { 'primary': '...', 'secondary': '...' },
     *          'tag': '...',
     *          'class': [ '...', '...' ],
     *          'html': { 'xxx': '...', 'zzz': '...' },
     *      }
     *
     * @param string $text      A text to display on the button (label).
     * @param array $options    An array of options.
     * @return string
     */
    public function button($text, $options = array())
    {
        return $this->helper->button($text, $options);
    }

    /**
     * Renders a button with a link.
     *
     * Example:
     *      {{ jui_button_link('homepage', 'Home') }}
     *
     * @param string $routeOrUrl   A route name or an URL (which begins with http... or /...).
     * @param string $text         The text to display on the button link.
     * @param array $options       An array of options.
     * @param boolean $absolute    Whether the generated url should be absolute or relative (default: false).
     * @return string
     */
    public function buttonLink($route, $text, $options = array(), $absolute = false)
    {
        return $this->helper->buttonLink($route, $text, $options, $absolute);
    }

    /**
     * Renders an info box.
     *
     * Example:
     *     {{ jui_info_box('Hello, World !', 'Information') }}
     *
     * @param string $message   A message to display in the box.
     * @param string $replace   An array of replacements.
     * @param string $label     A label for this box (default: 'Info:').
     * @return string
     */
    public function infoBox($text, $replace = array(), $label = 'Info:')
    {
        return $this->helper->infoBox($text, $replace, $label);
    }

    /**
     * Renders an error box.
     *
     * @param string $message   A message to display in the box.
     * @param string $replace   An array of replacements.
     * @param string $label     A label for this box (default: 'Error:').
     * @return string
     */
    public function errorBox($text, $replace = array(), $label = 'Error:')
    {
        return $this->helper->errorBox($text, $replace, $label);
    }

    /**
     * Renders an icon.
     *
     * Example:
     *      {{ jui_icon('tag') }}
     *      {{ jui_icon('wrench') }}
     *
     * @param string $icon      An icon name.
     * @return string
     */
    public function icon($icon)
    {
        return $this->helper->icon($icon);
    }

    /**
     * Renders a 'submit' button.
     *
     * Example:
     *      {{ jui_submit({ 'AdminBundle' : 'btn_batch' } }}
     *
     * @param string $text         The text to display on the button link.
     * @param array $options       An array of options.
     * @return string
     */
    public function submit($text, $options = array())
    {
        return $this->helper->submit($text, $options);
    }
}
