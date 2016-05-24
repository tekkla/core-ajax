<?php
namespace Core\Ajax\Commands;

/**
 * AjaxCommandInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
interface AjaxCommandInterface
{

    /**
     * Action command type
     *
     * @var string
     */
    const TYPE_ACT = 'act';

    /**
     * DOM command type
     *
     * @var string
     */
    const TYPE_DOM = 'dom';

    /**
     * Sets the ajax command arguments array
     *
     * @param mixed $args
     */
    public function setArgs($args);

    /**
     * Returns ajax command arguments
     *
     * @return mixed
     */
    public function getArgs();

    /**
     * Sets ajax command group type
     *
     * @param string $type
     *            Type of this command can by either be 'dom' oder 'act'
     */
    public function setType($type);

    /**
     * Returns ajax command type
     *
     * @return string
     */
    public function getType();

    /**
     * Sets function of ajax command
     *
     * @param string $fn
     *            jQuery functionname of this command
     */
    public function setFunction($fn);

    /**
     * Returns ajax command function
     *
     * @return string
     */
    public function getFunction();

    /**
     * Sets an optional identifier for this command
     *
     * @param string $id
     *            Command identifier
     */
    public function setId($id);

    /**
     * Returns command id
     *
     * @return string
     */
    public function getId();
}
