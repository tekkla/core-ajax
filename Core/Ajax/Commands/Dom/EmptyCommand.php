<?php
namespace Core\Ajax\Commands\Dom;

/**
 * EmptyCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class EmptyCommand extends AbstractDomCommand
{

    /**
     * Constructor
     *
     * jQuery($selector).empty();
     *
     * @param string $selector
     *            The selector
     */
    public function __construct($selector)
    {
        $this->setFunction(self::FUNC_EMPTY);
        $this->setSelector($selector);
        $this->setArgs(false);
    }
}
