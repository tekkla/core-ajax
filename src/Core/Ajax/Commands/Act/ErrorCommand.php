<?php
namespace Core\Ajax\Commands\Act;

/**
 * ErrorCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class ErrorCommand extends AbstractActCommand
{

    /**
     * Constructor
     *
     * @param string $error
     *            The error message
     * @param string $target
     *            Optional target where to append the message
     */
    public function __construct($error, $target = '')
    {
        if (empty($selector)) {
            $target = 'body';
        }

        $this->setFunction(self::FUNC_ERROR);
        $this->setArgs([
            $error,
            $target
        ]);
    }
}

