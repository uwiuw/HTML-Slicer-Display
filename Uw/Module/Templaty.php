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
 * @link      http://uwiuw.com/outerrim/
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
 * @link       http://uwiuw.com/outerrim/
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
     *
     * @todo buat form ini memiliki template resoucesnya sendiri. atau buat helper
     * bagi pembuatan form seperti ci lakukan
     */
    function getButton(array $args)
    {
        $themeName = UW_NAME;
        $actionname = 'actiontest';
        $id = 'button_' . $themeName;
        $default = array(
            'name' => ucfirst($themeName),
            'method' => 'post',
            'id' => $id,
            'ajax' => $actionname,
            'button_id' => $id . '_url',
            'button_url_output' => $id . '_url_output',
            'action' => admin_url('admin-ajax.php', false),
            'action_value' => 'goto',
            'submit_title' => 'Save',
            'nonce_field' => wp_nonce_field($actionname, "_wpnonce", true, false),
        );
        $args = array_merge($default, $args);

        extract($args);
        $button = <<<HTML
<form method="$method"
        id="$id"
        name="$form_id"
        action="$action" style="display:none">
    <input type="hidden" name="$themeName" value="$id" />
    <input type="hidden" name="action" value="$action_value" />
    <input type="submit"
        name="Submit"
        class="button-primary"
        value="$submit_title" style="display:none" />
    $nonce_field
</form>
<span class="$button_url_output">
    <a href="#"
        id="$button_id"
        class="button-primary"
        style="display:inline-block;margin:5px">$submit_title</a>
</span>
HTML;

        return $button;

    }

    /**
     * Get html ajax button
     *
     * @param string $button_id the link id name
     * @param string $form_id   the form id name
     * @param string $output    the class name of ajax respond container
     *
     * @return html
     */
    function getButtonAjax($button_id, $form_id, $output = 'ajax_reponse_output')
    {
        $button = <<<HTML
    jQuery('#$button_id').click(function()
    {
        jQuery.post(ajaxurl, jQuery('#$form_id').serialize(), function(data) {
            if (data) {
                jQuery('.$output').html(data);
            }
//        alert(data);
//        jQuery.print(data);
        });
    });
HTML;
        return $button;

    }

}

