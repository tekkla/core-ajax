<?php
namespace Core\Ajax\Commands\Dom;

use Core\Ajax\Commands\AbstractCommand;

/**
 * AbstractDomCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractDomCommand extends AbstractCommand implements DomCommandInterface
{

    protected $type = self::TYPE_DOM;

    protected $selector = 'body';

    public function setSelector($selector)
    {
        if (!empty($selector)) {
            $this->selector = $selector;
        }
    }

    public function getSelector()
    {
        return $this->selector;
    }
}
