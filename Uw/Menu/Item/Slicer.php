<?php

class Uw_Menu_Item_Slicer extends Uw_Menu_Item_Abstract {

    public $title = 'Slicer';
    public $description = 'You can choose which html template you going to show to public';

    function init() {

        $path = UW_PATH . SEP . 'xhtml';
        $HtmlFileList = new Uw_Module_HtmlFileList($path);
        try
        {
            $args = array(
                'headertitle' => 'Your Portfolio',
                'footertitle' => 'Select All',
                'in_tbody' => 'class="plugins"',
                'content' => $this->transList($HtmlFileList->getList()), 
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
     * Return list of themes in xhtml directory
     *
     * @param array $o list of themes in xhtml directory
     *
     * @return string
     */
    function transList(array $o) {
        if (empty($o)) {
            throw new Uw_Exception('EM997 : Empty directory list');
        }

        $output = '';
        foreach ($o as $theme => $item) {
            $active = '';
            if ($item['Screenshot'] && $item['Indexfile']) {
                $active = 'active';
            }
            extract($item);

            $th = $this->html->getTableTh('check-column', '<input type="checkbox" name="checked[]" value="' . $Name . '">');
            $tdContent = <<<HTML
        <img src="$Screenshot" width="64" height="64" style="float:left; padding: 5px">
        <strong><a href="$Indexfile">$Name $Version</a></strong>
        <p>$Description</p>
        <p>$Author</p>
HTML;
            $td = $this->html->getTableTd('plugin-title', $tdContent);
            $output .= $this->html->getTableTr($active, $th . $td);
        }

        return $output;

    }

}