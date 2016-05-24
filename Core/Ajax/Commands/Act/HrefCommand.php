<?php
namespace Core\Ajax\Commands\Act;

/**
 * HrefCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class HrefCommand extends AbstractActCommand
{

    /**
     *
     * @param string $href
     */
    public function __construct($href)
    {
        $this->setFunction(self::FUNC_HREF);
        $this->setArgs($href);
    }
}
