<?php

class Uw_Menu_Item_Emergency extends Uw_Menu_Item_Abstract {

    public $title = 'Emergency';
    public $description = 'Various emergency mechanism';

    function init() {
        $path = UW_PATH . SEP . 'xhtml';
        try
        {
            $o = $this->transList($this->buttons);
        } catch (Exception $exc)
        {
            $this->content = $exc->getMessage();
        }

        $body = $this->html->getTableBody('emergency', $o);
        $body = $this->html->getTable('Emergency Action', 'Select All', $body);
        $this->content = <<<HTML
$nav
$body
HTML;

    }

    /**
     * Return list of themes in xhtml directory
     *
     * @param array $o list of themes in xhtml directory
     *
     * @return string
     */
    function transList(array $o) {
        if (empty($o)) {
            throw new Uw_Menu_Exception('EM997 : Empty directory list');
        }

        $output = '';
        foreach ($o as $theme => $item) {
            if (file_exists(UW_PATH . SEP . 'assets' . SEP . $item['Icon'])) {
                $item['Icon'] = UW_URL . '/assets/' . $item['Icon'];
            }

            extract($item);
            $th = $this->html->getTableTh('check-column', '<input type="checkbox" name="checked[]" value="' . $Name . '">');
            $args = array(
                'name' => $Name,
                'id' => $Name,
                'button_url_id' => $button_id,
                'button_url_output' => $button_id_output,
                'method' => 'post',
                'ajax' => $Ajax,
                'action' => admin_url('admin-ajax.php', false),
                'submit_title' => $Title,
                'nonce_field' => wp_nonce_field($actionname, "_wpnonce", true, false),
            );

            $button = $this->html->getButton($args);
            $tdContent = <<<HTML
<img src="$Icon" width="64" height="64" style="float:left; padding: 5px">
<p class="haikamu">$Description</p>
$button
HTML;
            $td = $this->html->getTableTd('emergency-title', $tdContent);
            $output .= $this->html->getTableTr('', $th . $td);
        }

        return $output;

    }

}