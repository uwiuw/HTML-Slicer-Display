<?php

class Uw_Module_HtmlCreator {

    function getTableBody($class, $content) {
        $content = <<<HTML
<tbody class="$class">
$content
</tbody>
HTML;
        return $content;

    }

    function getTable($headertitle, $footertitle, $content) {
        $content = <<<HTML
<table class="widefat" cellspacing="0" id="update-themes-table">
    <thead>
        <tr>
            <th scope="col" class="manage-column check-column"><input type="checkbox" id="themes-select-all"></th>
            <th scope="col" class="manage-column"><label for="themes-select-all">$headertitle</label></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="manage-column check-column"><input type="checkbox" id="themes-select-all-2"></th>
            <th scope="col" class="manage-column"><label for="themes-select-all-2">$footertitle</label></th>
        </tr>
    </tfoot>
    $content
</table>
HTML;
        return $content;

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

}
      