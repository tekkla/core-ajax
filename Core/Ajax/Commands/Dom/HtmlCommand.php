<?php
namespace Core\Ajax\Commands\Dom;

/**
 * HtmlCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class HtmlCommand extends AbstractDomCommand
{

    /**
     * jQuery($selector).html($content)
     *
     * @param string $selector
     *            The selector
     * @param string $content
     *            The content
     */
    public function __construct($selector, $content)
    {
        $this->setFunction(self::FUNC_HTML);
        $this->setSelector($selector);
        $this->setArgs($content);
    }
}
