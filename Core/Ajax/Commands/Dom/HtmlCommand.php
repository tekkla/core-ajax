<?php
namespace Core\Ajax\Commands\Dom;

/**
 * HtmlCommand.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class HtmlCommand extends AbstractDomCommand
{

    /**
     * jQuery($selector).html($html)
     *
     * @param string $selector
     *            The selector
     * @param string $html
     *            The content
     */
    public function __construct($selector, $html)
    {
        $this->setFunction(self::FUNC_HTML);
        $this->setSelector($selector);
        $this->setArgs($html);
    }

    /**
     * Sets html() argument
     *
     * @param string $html
     *            The argument to use with .html()
     */
    public function setHtml($html)
    {
        $this->setArgs($html);
    }

    /**
     * Set html content
     *
     * @return mixed
     */
    public function getHtml()
    {
        return $this->getArgs();
    }
}
