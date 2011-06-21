<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\FrameworkBundle\Tests\Templating\Helper;

require_once __DIR__.'/Fixtures/StubTemplateNameParser.php';
require_once __DIR__.'/Fixtures/StubTranslator.php';

use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper;
use Symfony\Bundle\FrameworkBundle\Tests\Templating\Helper\Fixtures\StubTemplateNameParser;
use Symfony\Bundle\FrameworkBundle\Tests\Templating\Helper\Fixtures\StubTranslator;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Tests\Component\Form\AbstractDivLayoutTest;

class FormHelperTest extends AbstractDivLayoutTest
{
    protected $helper;

    protected function setUp()
    {
        parent::setUp();

        $root = realpath(__DIR__.'/../../../Resources/views');
        $rootCustom = realpath(__DIR__.'/Resources');
        $templateNameParser = new StubTemplateNameParser($root, $rootCustom);
        $loader = new FilesystemLoader(array());
        $engine = new PhpEngine($templateNameParser, $loader);

        $this->helper = new FormHelper($engine);

        $engine->setHelpers(array(
            $this->helper,
            new TranslatorHelper(new StubTranslator()),
        ));
    }

    protected function tearDown()
    {
        $this->helper = null;
    }

    protected function renderEnctype(FormView $view)
    {
        return (string)$this->helper->enctype($view);
    }

    protected function renderLabel(FormView $view, $label = null, array $vars = array())
    {
        return (string)$this->helper->label($view, $label, $vars);
    }

    protected function renderErrors(FormView $view)
    {
        return (string)$this->helper->errors($view);
    }

    protected function renderWidget(FormView $view, array $vars = array())
    {
        return (string)$this->helper->widget($view, $vars);
    }

    protected function renderRow(FormView $view, array $vars = array())
    {
        return (string)$this->helper->row($view, $vars);
    }

    protected function renderRest(FormView $view, array $vars = array())
    {
        return (string)$this->helper->rest($view, $vars);
    }
}
