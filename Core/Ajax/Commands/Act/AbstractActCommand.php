<?php
namespace Core\Ajax\Commands\Act;

use Core\Ajax\Commands\AbstractCommand;

/**
 * AbstractActCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractActCommand extends AbstractCommand implements ActCommandInterface
{

    protected $type = self::TYPE_ACT;
}
