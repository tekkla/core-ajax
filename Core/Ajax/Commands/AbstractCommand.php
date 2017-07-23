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
     * Identifier setable to use mainly on debugging
     *
     * @var string
     */
    protected $id = '';

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::setArgs()
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::setType()
     */
    public function setType(string $type)
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
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::setFunction()
     */
    public function setFunction(string $function)
    {
        if (empty($function)) {
            Throw new CommandException('Empty functionname is not permitted.');
        }
        
        $this->function = $function;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::getType()
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::getArgs()
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::getFunction()
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::setId()
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\CommandInterface::getId()
     */
    public function getId(): string
    
    {
        return $this->id;
    }
}
