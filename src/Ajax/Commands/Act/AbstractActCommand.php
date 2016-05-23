<?php
namespace Core\Ajax\Commands\Act;

use Core\Ajax\Commands\AbstractAjaxCommand;

/**
 * AbstractActCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractActCommand extends AbstractAjaxCommand implements ActCommandInterface
{

    protected $type = self::TYPE_ACT;
}
