<?php
namespace Core\Ajax\Commands\Act;

/**
 * ActCommandInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
interface ActCommandInterface
{
    /**
     * alert()
     *
     * @var string
     */
    const FUNC_ALERT = 'alert';

    /**
     * confirm()
     *
     * @var string
     */
    const FUNC_CONFIRM = 'confirm';

    /**
     * jQuery.getScript()
     *
     * @var string
     */
    const FUNC_GETSCRIPT = 'getScript';

    /**
     * location.href()
     *
     * @var string
     */
    const FUNC_HREF = 'href';

    /**
     * Error display
     *
     * @var string
     */
    const FUNC_ERROR = 'error';
}
