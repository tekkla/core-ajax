<?php
namespace Core\Ajax\Commands\Act;

/**
 * JQueryGetScriptCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class JQueryGetScriptCommand extends AbstractActCommand
{

    protected $function = 'jQuery.getScript';

    /**
     * Constructor
     *
     * @param string $url
     *            The url of the script
     */
    public function __construct($url)
    {
        $this->args = $url;
    }

    /**
     * Sets url of script to get
     *
     * @param string $url
     *            The url of the script
     */
    public function setUrl($url)
    {
        $this->args = $url;
    }

    /**
     * Returns set script url
     *
     * @return null|string
     */
    public function getUrl()
    {
        if (!empty($this->args)) {
            return $this->args;
        }
    }
}
