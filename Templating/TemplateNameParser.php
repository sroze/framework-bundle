<?php

namespace Symfony\Bundle\FrameworkBundle\Templating;

use Symfony\Component\Templating\TemplateNameParser as BaseTemplateNameParser;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * TemplateNameParser parsers template name from the short notation
 * "bundle:section:template.format.renderer" to a template name
 * and an array of options.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class TemplateNameParser extends BaseTemplateNameParser
{
    /**
     * Parses a template to a template name and an array of options.
     *
     * @param string $name     A template name
     * @param array  $defaults An array of default options
     *
     * @return array An array composed of the template name and an array of options
     */
    public function parse($name, array $defaults = array())
    {
        $parts = explode(':', $name);
        if (3 !== count($parts)) {
            throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name));
        }

        $options = array_replace(
            array(
                'format' => '',
            ),
            $defaults,
            array(
                'bundle'     => str_replace('\\', '/', $parts[0]),
                'controller' => $parts[1],
            )
        );

        $elements = explode('.', $parts[2]);
        if (3 === count($elements)) {
            $parts[2] = $elements[0];
            $options['format'] = '.'.$elements[1];
            $options['renderer'] = $elements[2];
        } elseif (2 === count($elements)) {
            $parts[2] = $elements[0];
            $options['renderer'] = $elements[1];
        } else {
            throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name));
        }

        return array($parts[2], $options);
    }
}
