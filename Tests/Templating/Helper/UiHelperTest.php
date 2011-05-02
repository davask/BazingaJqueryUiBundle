<?php

namespace Bazinga\JqueryUiBundle\Templating\Helper;

class UiHelperTest extends \PHPUnit_Framework_TestCase
{
    protected $helper;

    public function setUp()
    {
        $router     = $this->getMock('Symfony\Component\Routing\Router', array(), array(), '', false);
        $translator = $this->getMock('Symfony\Component\Translation\Translator', array(), array(), '', false);
        $request    = $this->getMock('Symfony\Component\HttpFoundation\Request', array(), array(), '', false);

        $this->helper = new UiHelper($router, $translator, $request);
    }

    public function test()
    {
    }
}
