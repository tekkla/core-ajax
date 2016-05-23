<?php
namespace Core\Ajax\Commands\Dom;

/**
 * DomCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class DomCommand extends AbstractDomCommand
{

    /**
     * jQuery($selector).$function($content)
     *
     * @param string $selector
     *            The selector
     * @param string $content
     *            The content
     */
    public function __construct($selector, $function, $content)
    {
        $this->setFunction($function);
        $this->setSelector($selector);
        $this->setArgs($content);
    }
}
