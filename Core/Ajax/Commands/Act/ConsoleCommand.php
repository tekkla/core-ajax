<?php
namespace Core\Ajax\Commands\Act;

/**
 * ConsoleCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class ConsoleCommand extends AbstractActCommand
{

    protected $log_type = 'log';

    /**
     * Constructor
     *
     * @param string $text
     *            Text to send to console
     * @param string $type
     *            The log type to use
     */
    public function __construct($text, $type = 'log')
    {
        $this->setLogType($type);
        $this->args = $text;
    }

    /**
     * Sets the console logging type like 'log', 'info', 'debug' etc
     *
     * @param string $type
     *            The log typ
     */
    public function setLogType($type)
    {
        if (empty($type)) {
            $type = 'log';
        }

        $this->log_type = $type;
        $this->function = 'console.' . $this->log_type;
    }

    /**
     * Returns the log type.
     *
     *
     * @return string
     */
    public function getLogType()
    {
        return $this->log_type;
    }

    /**
     * Sets the text to send to console
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->args = $text;
    }

    /**
     * Returns the text to log.
     * Will be null when no test was set.
     *
     * @return null|string
     */
    public function getText()
    {
        if (!empty($this->args)) {
            return $this->args;
        }
    }
}