<?php

class Uw_Menu_Item_Slicer extends Uw_Menu_Item_Abstract {

    public $title = 'Slicer';
    public $description = 'You can choose which html template you going to show to public';

    function init() {
        try
        {
            $args = array(
                'headertitle' => 'Portfolio',
                'footertitle' => 'Select All',
                'in_tbody' => 'class="plugins"',
                'content' => $this->_getContent(),
            );
            $this->content = $this->html->getTemplate('Table.php', $args);
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
     * @param array $o list of themes in xhtml directory
     *
     * @return string
     */
    function _getContent() {
        $path = UW_PATH . SEP . 'xhtml';
        $HtmlFileList = new Uw_Module_HtmlFileList($path);
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
                $Button .= $this->html->getButton(array(
                    'name' => $Name,
                    'id' => $Name,
                    'button_url_id' => $button_id,
                    'button_url_output' => $button_id_output,
                    'method' => 'post',
                    'ajax' => $Ajax,
                    'action' => admin_url('admin-ajax.php', false),
                    'action_value' => $item['Name'],
                    'submit_title' => $Title,
                    'nonce_field' => wp_nonce_field($Ajax, "_wpnonce", true, false)));
            }

            extract($item);
            $args = array(
                'screenshot' => $Screenshot,
                'imgcls' => 'width="64" height="64" style="float:left; padding: 5px"');
            $Img = $this->html->getTemplate('Img.php', $args);
            $content = $this->html->getTemplate('Slicer_Content.php', array(
                'Author' => $Author,
                'Indexfile' => $Indexfile,
                'Name' => $Name,
                'Version' => $Version,
                'Description' => $Description,
                'QuickEdit' => $this->html->getTemplate('Quick_Edit.php', array(
                    'Author' => $Author, //@quickedit
                ))));
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
        }

        return $output;

    }

}