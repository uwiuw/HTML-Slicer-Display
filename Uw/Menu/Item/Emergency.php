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
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Menu_Item_Slicer
 *
 * Slicer menu page data for rendering
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Item
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Menu_Item_Emergency extends Uw_Menu_Item_Abstract
{

    public $title = 'Emergency';
    public $description = 'Various emergency mechanism';

    /**
     * Inititate the process of rendenring page and set the value of $content
     *
     * @return void
     */
    function selfRender()
    {
        try
        {
            $args = array(
                'headertitle' => 'Emergency Action',
                'footertitle' => 'Select All',
                'in_tbody' => getCls('emergency'),
                'content' => $this->_getContent());
            $this->content = $this->html->getTemplate('Table.php', $args);
            $this->_regAjaxButton('slicer_page_emergency');
        } catch (Exception $exc)
        {
            if (is_a($exc, 'Uw_Exception')) {
                $this->content = $exc->getMessage();
            } else {
                $this->content = 'Exception occurs outside framework operation';
            }
        }

    }

    /**
     * Get content of the page. Build the emergency feature
     *
     * @return string
     */
    protected function _getContent()
    {
        $o = $this->buttons;
        if (empty($o)) {
            throw new Uw_Exception('EM997 : Emergency button is empty');
        }

        $output = '';
        foreach ($o as $theme => $item) {
            if (file_exists2(UW_PATH . SEP . 'assets' . SEP . $item['Icon'])) {
                $item['Icon'] = UW_URL . '/assets/' . $item['Icon'];
            }

            extract($item);

            $args = array(
                'screenshot' => $Icon,
                'imgcls' => 'width="64" height="64" style="float:left;padding:5px"');
            $Img = $this->html->getTemplate('Img.php', $args);
            $content = $this->html->getTemplate('Emergency_Content.php', array('Description' => $Description ));

            $args = array(
                'tbody_class' => getCls($active),
                'th_class' => getCls('check-column'),
                'td_class' => getCls('plugin-title'),
                'disabled' => $disabled,
                'Name' => $Name,
                'Img' => $Img,
				'Button' => $this->html->getButton(array(
                    'name' => $Name,
                    'id' => $Name,
                    'button_id' => $button_id,
                    'ajax_response_output' => $ajax_response_output,
                    'method' => 'post',
                    'ajax' => $Ajax,
                    'action' => admin_url('admin-ajax.php', false),
                    'action_value' => $item['Name'],
                    'submit_title' => $Title,
                    'nonce_field' => wp_nonce_field($Ajax, "_wpnonce", true, false))
                ),
                'content' => $content);
            $output .= $this->html->getTemplate('Slicer_TD.php', $args);
        }

        return $output;

    }

}