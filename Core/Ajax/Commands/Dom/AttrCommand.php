<?php
namespace Core\Ajax\Commands\Dom;

/**
 * AttrCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class AttrCommand extends AbstractDomCommand
{

    /**
     * Constructor
     *
     * jQuery($selector).attr($property, $value)
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
        $this->setFunction(self::FUNC_ATTR);
        $this->setSelector($selector);
        $this->setArgs([
            $property,
            $value
        ]);
    }
}
