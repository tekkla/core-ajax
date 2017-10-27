<?php
namespace Core\Ajax\Commands\Dom;

use Core\Ajax\Commands\AbstractAjaxCommand;
use Core\Ajax\Commands\AjaxCommandInterface;

/**
 * AbstractDomCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
abstract class AbstractDomCommand extends AbstractAjaxCommand implements DomCommandInterface
{

    protected $type = self::TYPE_DOM;

    protected $selector = 'body';

    /**
     * 
     * {@inheritDoc}
     * @see \Core\Ajax\Commands\Dom\DomCommandInterface::setSelector()
     */
    public function setSelector($selector)
    {
        if (!empty($selector)) {
            $this->selector = $selector;
        }
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Core\Ajax\Commands\Dom\DomCommandInterface::getSelector()
     */
    public function getSelector()
    {
        return $this->selector;
    }
}
