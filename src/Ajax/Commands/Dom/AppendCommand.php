<?php
namespace Core\Ajax\Commands\Dom;

/**
 * PrependCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class PrependCommand extends AbstractDomCommand
{

    /**
     * Constructor
     *
     * jQuery($selector).prepend($content)
     *
     * @param string $selector
     *            The selector
     * @param string $content
     *            The content
     */
    public function __construct($selector, $content)
    {
        $this->setFunction(self::FUNC_PREPEND);
        $this->setSelector($selector);
        $this->setArgs($content);
    }
}
