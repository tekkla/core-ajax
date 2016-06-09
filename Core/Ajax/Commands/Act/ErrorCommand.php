<?php
namespace Core\Ajax\Commands\Act;

/**
 * ErrorCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class ErrorCommand extends AbstractCallCommand
{

    protected $call_function = 'CORE.AJAX.COMMAND.error';

    protected $target;

    protected $error;

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
        if (empty($error)) {
            $error = 'Error';
        }

        if (empty($target)) {
            $target = 'body';
        }

        $this->error = $error;
        $this->target = $target;

        $this->setCallArgument([
            $this->target,
            $this->error
        ]);
    }

    public function setError($error) {

        if ($error instanceof \Throwable) {
            $error = $error->getMessage();
        }

        $this->setCallArgument([
            $this->target,
            $this->error

        ]);
    }

    public function getError()
    {
        return $this->getCallArgument()[1];
    }
}

