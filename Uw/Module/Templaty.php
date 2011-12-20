<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Module
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Module_Templaty
 *
 * Wrapper for Atrim_Core_Model_Resource_Template_AtTemplate
 *
 * @category   Uw
 * @package    Uw_Module
 * @subpackage Uw_Module_Templaty
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Module_Templaty
{

    /**
     * Templating handler
     * @var Atrim_Core_Model_Resource_Template_AtTemplate
     */
    public $model;

    /**
     * Constractor
     *
     * @param object $templateObj the instance of template onject
     */
    function __construct($templateObj = '')
    {
        if (is_object($templateObj)) {
            $this->model = $templateObj;
        } else {
            $fl = UW_PATH . SEP . 'Uw' . SEP . '3Party' . SEP . 'atTemplate.php';
            include_once $fl;
            $this->model = new Atrim_Core_Model_Resource_Template_AtTemplate;
            $this->model->reConstruct(
                array(
                    'resourcePath' => UW_PATH . SEP . 'Uw' . SEP . 'Resources',
                    'homePath' => UW_PATH,
                )
            );
        }

    }

    /**
     * Call magic function
     *
     * Method have dependency into
     *
     * @param array $name missing method name
     * @param array $args arguments
     *
     * @return mixed
     */
    function __call($name, $args)
    {
        return call_user_func_array(array($this->model, $name), $args);

    }

    /**
     * Get html of ajaxed form
     *
     * @param array $args various argument for creating button
     *
     * @return html
     */
    function getButton(array $args)
    {
        $themeName = UW_NAME;
        $actionname = 'actiontest';
        $default = array(
            'name' => ucfirst($themeName),
            'method' => 'post',
            'id' => 'button_' . $themeName,
            'form_id' => $themeName,
            'theme_name' => $themeName,
            'ajax' => $actionname,
            'button_id' => 'button_' . $themeName . '_url',
            'ajax_response_output' => 'button_' . $themeName . '_url_output',
            'action' => admin_url('admin-ajax.php', false),
            'action_value' => 'goto',
            'submit_title' => 'Save',
            'nonce_field' => wp_nonce_field($actionname, "_wpnonce", true, false),
        );
        $args = array_merge($default, $args);


        return $this->model->getTemplate('Button_Form.php', $args);

    }

    /**
     * Get html ajax button
     *
     * @param array $args berisi keys button_id, form_id, dan output
     *
     * @return html
     */
    function getButtonAjaxScript(array $args)
    {
        extract($args);

        $hasildebug = print_r($args, TRUE);
        echo "\n" . '<pre style="font-size:14px"><hr>' . '$hasildebug ' . htmlentities2($hasildebug) . '</pre>';


        return <<<HTML
    jQuery('#$button_id').click(function()
    {
        jQuery.post(ajaxurl, jQuery('#$form_id').serialize(), function(data) {
            if (data) {
                jQuery('.$ajax_response_output').html(data);
            }
        });
    });
HTML;

    }

}

