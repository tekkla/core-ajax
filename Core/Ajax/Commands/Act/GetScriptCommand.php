<?php
namespace Core\Ajax\Commands\Act;

use Core\Ajax\Commands\AjaxCommandException;

/**
 * GetScriptCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class GetScriptCommand extends AbstractActCommand
{

    /**
     * Constructor
     *
     * @param string $url
     */
    public function __construct($url)
    {
        if (empty($url)) {
            Throw new AjaxCommandException('Empty url is not permitted for GetScriptCommands.');
        }

        $this->setFunction(self::FUNC_GETSCRIPT);
        $this->setArgs($url);
    }
}

