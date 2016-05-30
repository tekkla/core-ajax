<?php
namespace Core\Ajax\Commands;

/**
 * AbstractCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractCommand implements CommandInterface
{

    /**
     * Kind of command
     *
     * @var string
     */
    protected $type;

    /**
     * Parameters to pass into the controlleraction
     *
     * @var mixed
     */
    protected $args;

    /**
     * The type of the current ajax.
     *
     * @var string
     */
    protected $function;

    /**
     * Identifier settable to use mainly on debugging.
     *
     * @var string
     */
    protected $id = '';

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::setArgs()
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::setType()
     */
    public function setType($type)
    {
        if (empty($type)) {
            Throw new CommandException('Empty commandtype is not permitted.');
        }

        if ($type != self::TYPE_ACT && $type != self::TYPE_DOM) {
            Throw new CommandException(sprintf('%s is no valid commandtype', $type));
        }

        $this->type = $type;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::setFunction()
     */
    public function setFunction($function)
    {
        if (empty($function)) {
            Throw new CommandException('Empty functionname is not permitted.');
        }

        $this->function = $function;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::getArgs()
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::getFunction()
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::setId()
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Ajax\AjaxCommandInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }
}
