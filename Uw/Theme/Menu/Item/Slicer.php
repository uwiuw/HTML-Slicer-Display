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
 * Uw_Theme_Menu_Item_Slicer
 *
 * Slicer menu page data for rendering
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Theme_Menu_Item
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Menu_Item_Slicer extends Uw_Theme_Menu_Item_Abstract
{

    public $title = 'Slicer';
    public $description = 'You can choose which one public portofolio';

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
                'headertitle' => 'Portfolio',
                'footertitle' => 'Select All',
                'in_tbody' => getCls('plugins'),
                'content' => $this->_getContent(),
            );
            $this->content = $this->html->getTemplate('Table.php', $args);
            $this->_regAjaxButton(''); //bagian toplevel menu
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
     * Get content of the page. Build list of portofolio
     *
     * @return string
     * @todo cara kerja method ini tidak intuitif, dan terlalu banyak conditionalnya.
     *       Oleh karenanya dibuat aja class UW_BUTTON atau semacamnya yg khusus
     *       menerima input aja
     */
    protected function _getContent()
    {
        $path = UW_PATH . SEP . 'xhtml';
        $HtmlFileList = new Uw_Theme_Module_HtmlFileList($path);
        $o = $HtmlFileList->getList();
        if (empty($o)) {
            throw new Uw_Exception('EM997 : Portofolio is empty');
        }

        foreach ($o as $theme => $item) {
            $active = '';
            if ($item['Screenshot'] && $item['Indexfile']) {
                $active = 'active';
                $disabled = '';
            } else {
                $disabled = 'disabled="1"';
            }

            $Button = '';

            foreach ($this->buttons as $but) {
                extract($but);
                $Name = ajaxStr($Name, $item['Name']);
                $arrButton = array(
                    'form_id' => $Name,
                    'id' => $Name,
                    'button_id' => ajaxStr($button_id, $item['Name']),
                    'ajax_response_output' => $ajax_response_output . '_' . $item['Name'],
                    'method' => 'post',
                    'ajax' => $Ajax,
                    'action' => admin_url('admin-ajax.php', false),
                    'action_value' => $item['Name'],
                    'submit_title' => $Title,
                    'nonce_field' => wp_nonce_field($Ajax, "_wpnonce", true, false));
                $Button .= $this->html->getButton($arrButton);
                $newAjaxButton[$Name] = $arrButton;
            }

            extract($item);

            //@todo refacto:ada html/css inisiasi disini float:left;padding:5px
            $args = array(
                'screenshot' => $Screenshot,
                'imgcls' => 'width="64" height="64" style="float:left;padding:5px"');
            $Img = $this->html->getTemplate('Img.php', $args);

            $content = $this->html->getTemplate('Slicer_Content.php', array(
                'Author' => $Author,
                'Indexfile' => $Indexfile,
                'Name' => $Name,
                'Version' => $Version,
                'Description' => $Description,
                'QuickEdit' => $this->html->getTemplate('Quick_Edit.php', array(
                    'Hidden_ID' => 'hiddenedit' . '_' . $Name,
                    'Name' => $Name,
                    'Author' => $Author,
                    'Description' => $Description)
                )
                )
            );

            $args = array(
                'tbody_class' => getCls($active),
                'th_class' => getCls('check-column'),
                'td_class' => getCls('plugin-title'),
                'disabled' => $disabled,
                'Name' => $Name,
                'Img' => $Img,
                'Button' => $Button,
                'content' => $content,
            );
            $output .= $this->html->getTemplate('Slicer_TD.php', $args);
        } //end foreach

        $this->ajax->setButtonArgs($newAjaxButton);
        return $output;

    }

}