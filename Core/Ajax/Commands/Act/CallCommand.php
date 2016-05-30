<?php
namespace Core\Ajax\Commands\Act;

/**
 * CallCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class CallCommand extends AbstractCallCommand
{

    /**
     * Constructor
     *
     * @param string $function
     *            Name of javascript function to call
     * @param array $args
     *            Optional indexed array with arguments to pass into function to call
     */
    public function __construct($function, $args = null)
    {
       $this->setCallFunction($function);

        if (isset($args)) {
            $this->setCallArgument($args);
        }
    }
}
