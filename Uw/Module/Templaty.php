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
 * @todo       hapus seluruh method class ini sehingga langsung memanggil class yg 
 *             dibungkusnya
 */
class Uw_Module_Templaty {

    private $model;

    function __construct($html = '') {

        if (is_object($html)) {
            $this->html = $html;
        } else {
            include_once( UW_PATH . SEP . 'Uw' . SEP . 'thirdparty' . SEP . 'atTemplate.php');
            $this->model = new Atrim_Core_Model_Resource_Template_AtTemplate;
            $this->model->reConstruct(
                array(
                    'resourcePath' => UW_PATH . SEP . 'Uw' . SEP . 'Resources',
                    'homePath' => UW_PATH,
                )
            );
        }

    }

    function __call($name, $arguments) {
        return call_user_func_array(array($this->model, $name), $arguments);
    }
 
    function getTableTr($class, $content) {
        $content = <<<HTML
<tbody class="$class">
$content
</tbody>
HTML;
        return $content;

    }

    function getTableTd($class, $content) {
        $content = <<<HTML
    <td class="$class">
        $content
    </td>
HTML;
        return $content;

    }

    function getTableTh($class, $content) {
        $content = <<<HTML
  <th scope="row" class="$class">
        $content
  </th>
HTML;
        return $content;

    }

    function getButton(array $args) {
        $themeName = UW_NAME;
        $actionname = 'actiontest';
        $id = 'button_' . $themeName;
        $default = array(
            'name' => ucfirst($themeName),
            'method' => 'post',
            'id' => $id,
            'ajax' => $actionname,
            'button_url_id' => $id . '_url',
            'button_url_output' => $id . '_url_output',
            'action' => admin_url('admin-ajax.php', false),
            'submit_title' => 'Save',
            'nonce_field' => wp_nonce_field($actionname, "_wpnonce", true, false),
        );
        $args = array_merge($default, $args);


        extract($args);
        $button = <<<HTML
<form method="$method" id="$id" name="$name" action="$action">
    <input type="hidden" name="$themeName" value="$id" />
    <input type="hidden" name="action" value="goto" />
    <input type="submit" name="Submit" class="button-primary" value="$submit_title" style="display:none" />
    $nonce_field
</form>
<a href="#" id="$button_url_id" class="button-primary">$submit_title</a>
<span class="$button_url_output"></span>
HTML;

        return $button;

    }

    function getButtonAjax($button_id, $form_id, $result)
    {
        $button = <<<HTML
    jQuery('#$button_id').click(function() {
        jQuery.post(ajaxurl, jQuery('#$form_id').serialize(), function(data) {
        jQuery('.$result').html(data);
        jQuery.print(data);
        });
    });
HTML;
        return $button;

    }

}

