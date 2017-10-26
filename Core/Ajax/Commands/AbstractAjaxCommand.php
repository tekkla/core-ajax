<?php
namespace Core\Ajax\Commands;

/**
 * AbstractAjaxCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
abstract class AbstractAjaxCommand implements AjaxCommandInterface
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
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::setArgs()
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::setType()
     */
    public function setType(string $type)
    {
        if (empty($type)) {
            Throw new AjaxCommandException('Empty commandtype is not permitted.');
        }
        
        if ($type != self::ACT && $type != self::DOM) {
            Throw new AjaxCommandException(sprintf('%s is no valid commandtype', $type));
        }
        
        $this->type = $type;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::setFunction()
     */
    public function setFunction(string $fn)
    {
        if (empty($fn)) {
            Throw new AjaxCommandException('Empty functionname is not permitted.');
        }
        
        $this->function = $fn;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::getType()
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::getArgs()
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::getFunction()
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::setId()
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Ajax\Commands\AjaxCommandInterface::getId()
     */
    public function getId(): string
    {
        return $this->id;
    }
}
