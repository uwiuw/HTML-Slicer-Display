<?php

class Uw_Menu_Item_Emergency extends Uw_Menu_Item {

    /**
     * html creator module
     * @var Uw_Module_HtmlCreator
     */
    private $html;
    public $title = 'Emergency';
    public $description = 'Various emergency mechanism';

    function init() {
        $this->html = new Uw_Module_HtmlCreator();
        $path = UW_PATH . SEP . 'xhtml';
        try
        {
            $dummy = array(
                'fix_htaccess' => array(
                    'Name' => 'fix_htaccess',
                    'Title' => 'Fixing htaccess',
                    'Description' => 'reconfigurate theme rewrite rule (will not change blog permalink)',
                    'Ajax' => 'fix_htaccess',
                    'Icon' => 'semlabs_terminal.png'
                ));
            $o = $this->transList($dummy);
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
            $nonce = wp_nonce_field('fix_htaccess', "_wpnonce", true, false);
            $args = array(
                'name' => $item['Name'],
                'id' => $item['Name'],
                'button_url_id' => $item['Name'] . '_url',
                'button_url_output' => $item['Name'] . '_url_output',
                'method' => 'post',
                'ajax' => $item['Ajax'],
                'action' => admin_url('admin-ajax.php', false),
                'submit_title' => $item['Title'],
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