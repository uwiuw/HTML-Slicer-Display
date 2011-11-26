<?php

class Uw_Module_UploadUpgrader {

    var $package;
    var $filename;

    function __construct($form, $urlholder, $uploads) {
        if (empty($uploads)) {
            $uploads = wp_upload_dir();
        }

        if (empty($_FILES[$form]['name']) && empty($_GET[$urlholder])) {
            wp_die(__('Please select a file'));
        }

        if (!empty($_FILES)) {
            $this->filename = $_FILES[$form]['name'];
        } else if (isset($_GET[$urlholder])) {
            $this->filename = $_GET[$urlholder];
        }

        //Handle a newly uploaded file, Else assume its already been uploaded
        if (!empty($_FILES)) {
            $this->filename = wp_unique_filename($uploads['basedir'], $this->filename);
            $this->package = $uploads['basedir'] . '/' . $this->filename;



            // Move the file to the uploads dir
            if (false === @ move_uploaded_file($_FILES[$form]['tmp_name'], $this->package)) {
                wp_die(sprintf(__('The uploaded file could not be moved to %s.'), $uploads['path']));
            }
        } else {
            $this->package = $uploads['basedir'] . '/' . $this->filename;
        }

    }

}