<?php

class Uw_Menu_Item_Emergency extends Uw_Menu_Item_Abstract {

    public $title = 'Emergency';
    public $description = 'Various emergency mechanism';

    function init() {
        $path = UW_PATH . SEP . 'xhtml';
        try
        {
            $args = array(
                'headertitle' => 'Emergency Action',
                'footertitle' => 'Select All',
                'in_tbody' => 'class="emergency"',
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
     * Get content of the page. Build the emergency feature
     * 
     * @return string
     */
    function _getContent() {
        $o = $this->buttons;
        if (empty($o)) {
            throw new Uw_Exception('EM997 : Emergency button is empty');
        }

        $output = '';
        foreach ($o as $theme => $item) {
            if (file_exists(UW_PATH . SEP . 'assets' . SEP . $item['Icon'])) {
                $item['Icon'] = UW_URL . '/assets/' . $item['Icon'];
            }

            extract($item);
            $args = array(
                'screenshot' => $Icon,
                'imgcls' => 'width="64" height="64" style="float:left; padding: 5px"');
            $Img = $this->html->getTemplate('Img.php', $args);
            $content = $this->html->getTemplate('Emergency_Content.php', array(
                'Description' => $Description,
                'Button' => $this->html->getButton(array(
                    'name' => $Name,
                    'id' => $Name,
                    'button_url_id' => $button_id,
                    'button_url_output' => $button_id_output,
                    'method' => 'post',
                    'ajax' => $Ajax,
                    'action' => admin_url('admin-ajax.php', false),
                    'submit_title' => $Title,
                    'nonce_field' => wp_nonce_field($Ajax, "_wpnonce", true, false))),
                ));
            
            $args = array(
                'tbody_class' => getCls($active),
                'th_class' => getCls('check-column'),
                'td_class' => getCls('plugin-title'),
                'disabled' => $disabled,
                'Name' => $Name,
                'Img' => $Img,
                'content' => $content,
            );
            $output .= $this->html->getTemplate('Slicer_TD.php', $args);
        }

        return $output;

    }

}