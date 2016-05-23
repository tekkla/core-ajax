<?php
namespace Core\Ajax\Commands\Dom;

/**
 * DomCommandInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
interface DomCommandInterface
{

    /**
     * jQuery.html()
     *
     * @var string
     */
    const FUNC_HTML = 'html';

    /**
     * jQuery.before()
     *
     * @var string
     */
    const FUNC_BEFORE = 'before';

    /**
     * jQuery.append()
     *
     * @var string
     */
    const FUNC_APPEND = 'append';

    /**
     * jQuery.prepend()
     *
     * @var string
     */
    const FUNC_PREPEND = 'prepend';

    /**
     * jQuery.empty()
     *
     * @var string
     */
    const FUNC_EMPTY = 'empty';

    /**
     * jQuery.css()
     *
     * @var string
     */
    const FUNC_CSS = 'css';

    /**
     * jQuery.attr()
     *
     * @var string
     */
    const FUNC_ATTR = 'attr';

    /**
     * Sets the DOM selector for this command
     *
     * @param string $selector
     *            DOM selector
     */
    public function setSelector($selector);

    /**
     * Returns command DOM selector
     *
     * @return string
     */
    public function getSelector();
}
