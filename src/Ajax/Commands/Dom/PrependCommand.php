<?php
namespace Core\Ajax\Commands\Dom;

/**
 * AppendCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class AppendCommand extends AbstractDomCommand
{

    /**
     * Constructor
     *
     * jQuery($selector).append($content)
     *
     * @param string $selector
     *            The selector
     * @param string $content
     *            The content
     */
    public function __construct($selector, $content)
    {
        $this->setFunction(self::FUNC_APPEND);
        $this->setSelector($selector);
        $this->setArgs($content);
    }
}
