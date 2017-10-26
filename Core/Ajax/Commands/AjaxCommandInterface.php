<?php
namespace Core\Ajax\Commands;

/**
 * AjaxCommandInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
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
     * @param array $args
     */
    public function setArgs(array $args);

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
    public function setType(string $type);

    /**
     * Returns ajax command type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Sets function of ajax command
     *
     * @param string $fn
     *            jQuery functionname of this command
     */
    public function setFunction(string $fn);

    /**
     * Returns ajax command function
     *
     * @return string
     */
    public function getFunction(): string;

    /**
     * Sets an optional identifier for this command
     *
     * @param string $id
     *            Command identifier
     */
    public function setId(string $id);

    /**
     * Returns command id
     *
     * @return string
     */
    public function getId(): string;
}
