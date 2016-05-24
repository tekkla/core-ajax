<?php
namespace Core\Ajax\Commands\Dom;

/**
 * CssCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class CssCommand extends AbstractDomCommand
{

    /**
     * Constructor
     *
     * jQuery($selector).css($property, $value)
     *
     * @param string $selector
     *            The selector
     * @param string $property
     *            The property
     * @param mixed $value
     *            The value
     */
    public function __construct($selector, $property, $value)
    {
        $this->setFunction(self::FUNC_CSS);
        $this->setSelector($selector);
        $this->setArgs([
            $property,
            $value
        ]);
    }
}
