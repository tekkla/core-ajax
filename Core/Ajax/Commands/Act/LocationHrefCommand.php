<?php
namespace Core\Ajax\Commands\Act;

/**
 * LocationHrefCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class LocationHrefCommand extends AbstractActCommand
{
    protected $function = 'location.assign';

    /**
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->args = $url;
    }

    /**
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->args = $url;
    }

    /**
     *
     * @return null|string
     */
    public function getHref()
    {
        if (isset($this->args)) {
            return $this->args;
        }
    }
}
