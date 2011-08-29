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

    function getButton(array $args) {
        $themeName = UW_NAME;
        $actionname = 'actiontest';
        $id = 'button_' . $themeName;
        $default = array(
            'name' => ucfirst($themeName),
            'method' => 'post',
            'id' => $id,
            'ajax' => $actionname,
            'button_url_id' => $id . '_url',
            'button_url_output' => $id . '_url_output',
            'action' => admin_url('admin-ajax.php', false),
            'submit_title' => 'Save',
            'nonce_field' => wp_nonce_field($actionname, "_wpnonce", true, false),
        );
        $args = array_merge($default, $args);


        extract($args);
        $button = <<<HTML
<form method="$method" id="$id" name="$name" action="$action">
    <input type="hidden" name="$themeName" value="$id" />
    <input type="hidden" name="action" value="goto" />
    <input type="submit" name="Submit" class="button-primary" value="$submit_title" style="display:none" />
    $nonce_field
</form>
<a href="#" id="$button_url_id" class="button-primary">$submit_title</a>
<span class="$button_url_output"></span>
HTML;

        return $button;

    }

    function getButtonAjax($button_id, $form_id, $result)
    {
        $button = <<<HTML
    jQuery('#$button_id').click(function() {
        jQuery.post(ajaxurl, jQuery('#$form_id').serialize(), function(data) {
        jQuery('.$result').html(data);
        jQuery.print(data);
        });
    });
HTML;
        return $button;

    }

}

