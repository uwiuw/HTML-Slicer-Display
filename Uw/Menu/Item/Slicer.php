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
            throw new Uw_Exception('EM997 : Portofolio is empty');
        }

        $output = '';
        foreach ($o as $theme => $item) {
            $active = '';
            if ($item['Screenshot'] && $item['Indexfile']) {
                $active = 'active';
                $disabled = '';
            } else {
                $disabled = 'disabled="1"';
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
                'Button' => $Button,
                ));
            $args = array(
                'tbody_class' => getCls($active),
                'th_class' => getCls('check-column'),
                'td_class' => getCls('plugin-title'),
                'disabled' => $disabled,
                'Name' => $Name,
                'content' => $Img . $content,
            );
            $output .= $this->html->getTemplate('Slicer_TD.php', $args);
        }

        return $output;

    }

}