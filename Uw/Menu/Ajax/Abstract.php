<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Menu
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Menu_Ajax_Abstract
 *
 * Ajax abstract for all ajax
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Ajax
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
abstract class Uw_Menu_Ajax_Abstract
{

    protected $html;
    protected $_config;
    private $action;

    /**
     * Doing ajax operation and call die. This method will echo result of ajax
     * operation to be retrieve by related method to be process
     *
     * @return void
     */
    abstract public function doAjaxAction();

    /**
     * Constructor
     *
     * @param Uw_Config_Data     $data handler
     * @param Uw_Module_Templaty $html handler
     */
    final function __construct(Uw_Config_Data $data, Uw_Module_Templaty $html)
    {
        if (empty($this->_itemArgs)) {
            throw new Uw_Exception('E123 : Item arguments is empty');
        }
        $this->html = $html;
        $this->_config = &$data;
        $this->action = $_POST['action'];

    }

    /**
     * Hook public method for echoing injected ajax script for button ajax
     *
     * @return void
     */
    public function inject()
    {
        if ($this->_itemArgs) {
            foreach ($this->_itemArgs as $k => $v) {
                $o .= $this->html->getButtonAjax(
                    $v['button_id'], $v['form_id'], $v['button_id_output']
                );
            }
            $o = '<script type="text/javascript">' . $o . '</script>';
            echo $o;
        }

    }

    /**
     * Getter button ajax argument
     *
     * @return array
     */
    final function getButtons()
    {
        return $this->_itemArgs;

    }

    /**
     * Setter button ajax argument
     *
     * @param array $newItemArgs new argument to be set into property
     *
     * @return void
     */
    public function setButtonArgs(array $newItemArgs)
    {
        $this->_itemArgs = $newItemArgs;

    }

}