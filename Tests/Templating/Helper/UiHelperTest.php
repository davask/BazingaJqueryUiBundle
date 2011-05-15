<?php

namespace Bazinga\JqueryUiBundle\Templating\Helper;

/**
 * UiHelperTest class.
 *
 * @package JqueryUiBundle
 * @subpackage Templating.Helper
 * @author William DURAND <william.durand1@gmail.com>
 */
class UiHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Bazinga\JqueryUiBundle\Templating\Helper
     */
    protected $helper;

    /**
     * Initialize the helper.
     */
    public function setUp()
    {
        $container = new \Symfony\Component\DependencyInjection\Container();

        $container->set('translator', $this->getMockTranslator());
        $container->set('router', $this->getMockRouter());
        $container->set('request', $this->getMock('\Symfony\Component\HttpFoundation\Request'));

        $this->helper = new UiHelper($container);
    }

    /**
     * Test the link() method.
     */
    public function testLink()
    {
        $this->assertEquals('<a href="/">Home</a>', $this->helper->link('/', 'Home'));
        $this->assertEquals('<a href="/">Home</a>', $this->helper->link('/', 'Home', true));
        $this->assertEquals('<a href="/foo">Foo</a>', $this->helper->link('/foo', 'Foo'));
        $this->assertEquals('<a href="http://www.google.fr">Google</a>', $this->helper->link('http://www.google.fr', 'Google'));
        $this->assertEquals('<a href="http://www.google.fr">Google</a>', $this->helper->link('http://www.google.fr', 'Google', true));
    }

    /**
     * Returns a mock translator.
     * @return \Symfony\Component\Translation\TranslatorInterface
     */
    private function getMockTranslator()
    {
        $translator = $this->getMock('\Symfony\Component\Translation\TranslatorInterface');
        $translator
            ->expects($this->atLeastOnce())
            ->method('trans')
            ->will($this->returnArgument(0));

        return $translator;
    }

    /**
     * Returns a mock router.
     * @return \Symfony\Component\Routing\RouterInterface
     */
    private function getMockRouter()
    {
        $router = $this->getMock('\Symfony\Component\Routing\RouterInterface');

        return $router;
    }
}
