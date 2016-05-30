<?php
namespace Core\Ajax\Commands\Act;

/**
 * AlertCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class AlertCommand extends AbstractActCommand
{

    public function __construct($alert)
    {
        $this->setFunction('alert');
        $this->setArgs($alert);
    }
}

