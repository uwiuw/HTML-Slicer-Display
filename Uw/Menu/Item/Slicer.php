<?php

class Uw_Menu_Item_Slicer extends Uw_Menu_Item {

    public $title = 'Slicer';
    public $description = 'Your can choose which html template you going to show to public';

    function init() {
        $path = UW_PATH . SEP . 'xhtml';
        $HtmlFileList = new Uw_Module_HtmlFileList($path);
        try
        {
            $o = $this->transList($HtmlFileList->getList());
        } catch (Exception $exc)
        {
            $this->content = $exc->getMessage();
        }

        $this->content = <<<HTML
$nav
<table class="widefat" cellspacing="0" id="update-themes-table">
    <thead>
        <tr>
            <th scope="col" class="manage-column check-column"><input type="checkbox" id="themes-select-all"></th>
            <th scope="col" class="manage-column"><label for="themes-select-all">Your Portfolio</label></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="manage-column check-column"><input type="checkbox" id="themes-select-all-2"></th>
            <th scope="col" class="manage-column"><label for="themes-select-all-2">Select All</label></th>
        </tr>
    </tfoot>
    <tbody class="plugins">
       $o
    </tbody>
</table>

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

        $form_tr = '';
        foreach ($o as $theme => $item) {
            $active = '';
            if ($item['Screenshot'] && $item['Indexfile']) {
                $active = 'class="active"';
            }
            extract($item);

            $form_tr .=<<<HTML
<tr $active>
    <th scope="row" class="check-column">
        <input type="checkbox" name="checked[]" value="$Name">
    </th>
    <td class="plugin-title">
        <img src="$Screenshot" width="64" height="64" style="float:left; padding: 5px">
        <strong><a href="$Indexfile">$Name $Version</a></strong>
        <p>$Description</p>
        <p>$Author</p>
    </td>
</tr>
HTML;
        }

        return $form_tr;

    }

}