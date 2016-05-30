<?php
namespace Core\Ajax\Commands\Act;

/**
 * AbstractCallCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractCallCommand extends AbstractActCommand
{

    protected $function = 'call';

    /**
     *
     * @var mixed
     */
    protected $call_argument;

    /**
     *
     * @var string
     */
    protected $call_function;

    /**
     * Set argument for call function
     *
     * @param mixed $arg
     */
    public function setCallArgument($arg)
    {
        $this->call_argument = $arg;
        $this->args([
            $this->call_function,
            $this->call_argument
        ]);
    }

    /**
     *
     * @param mixed $arg
     */
    public function addCallArgument($arg)
    {
        $args = $this->call_argument ?? [];

        if (!is_array($args)) {
            $args = (array) $args;
        }

        $args[] = $arg;

        $this->call_argument = $args;

        $this->args = [
            $this->call_function,
            $this->call_argument
        ];
    }

    /**
     * Returns call argument
     *
     * @return mixed
     */
    public function getCallArgument()
    {
        if (isset($this->call_argument)) {
            return $this->call_argument;
        }
    }

    /**
     * Sets the call function
     *
     * @param string $function
     */
    public function setCallFunction($function)
    {
        $this->call_function = $function;
        $this->args = [
            $this->call_function,
            $this->call_argument
        ];
    }

    /**
     * Returns the call function
     */
    public function getCallFunction()
    {
         if (isset($this->call_function)) {
            return $this->call_function;
        }
    }
}
