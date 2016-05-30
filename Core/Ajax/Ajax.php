<?php
namespace Core\Ajax;

use Core\Ajax\Commands\Dom\DomCommandInterface;
use Core\Ajax\Commands\CommandInterface;

/**
 * Ajax.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Ajax
{

    /**
     * Ajax command stack
     *
     * @var array
     */
    private $commands = [];

    /**
     * Builds ajax definition and adds it to the ajaxlist
     */
    public function addCommand(CommandInterface $cmd)
    {
        $this->commands[] = $cmd;
    }

    /**
     * Builds the ajax command structure
     */
    public function process()
    {
        $ajax = [];

        /* @var $cmd \Core\Ajax\Commands\AjaxCommandInterface */
        foreach ($this->commands as $cmd) {

            // Create alert on missing target when type is in need-target list
            if ($cmd instanceof DomCommandInterface && empty($cmd->getSelector())) {
                $cmd->setSelector('body');
            }

            // Create funcion/arguments array
            $fa = [
                'f' => $cmd->getFunction(),
                'a' => $cmd->getArgs()
            ];

            if ($cmd instanceof DomCommandInterface) {
                $ajax['dom'][$cmd->getSelector()][] = $fa;
            }
            else {
                $ajax['act'][] = $fa;
            }
        }

        // Return JSON encoded ajax command stack
        return !empty($ajax) ? json_encode($ajax) : '';
    }

    /**
     * Returns the complete ajax command stack as it is
     *
     * @return array
     */
    public function getCommandStack()
    {
        return $this->commands;
    }

    /**
     * Cleans the current ajax command stack
     */
    public function cleanCommandStack()
    {
        $this->commands = [];
    }
}
