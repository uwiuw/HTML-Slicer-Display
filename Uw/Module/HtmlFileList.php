<?php

class Uw_Module_HtmlFileList {

    private $path;
    private $fileScreen = array(
        'screenshot.png',
        'screenshots.png',
        'screenshot.jpg',
        'screenshot.jpeg',
        'screenshots.jpg',
        'screenshot.jpeg',
        'screenshot.gif',
        'screenshots.gif',
    );
    private $fileIndex = array(
        'index.html',
        'index.htm',
    );
    private $fileStyle = array(
        'style.css',
    );
    private $pathStyle = array(
        'css',
        'assets',
        'asset',
        'images',
    );
    private $description = 'Vestibulum venenatis. Nulla vel ipsum. Proin rutrum, urna sit amet bibendum pellentesque';

    function __construct($path) {
        $this->path = $path;

    }

    /**
     * Get list of xhtml directory
     *
     * @return array
     */
    function getList() {
        if (!is_dir($this->path)) {
            throw new Uw_Module_Exception('E998 : path is invalid');
        }

        $directory = dir($this->path);
        $listFile = array();

        // Loop while the read method goes through each and
        // every file
        while ((FALSE !== ($dirname = $directory->read())))
        {
            // If an item is not "." and "..", then something
            // exists in the directory and it is not empty
            if (is_dir($this->path . SEP . $dirname) && $dirname != '.' && $dirname != '..') {
                $isDirNotEmpty = TRUE;
                $listFile[$dirname] = $this->_checkInsideDir($dirname);
            }
        }
        // Close the directory
        $directory->close();

        if ($isDirNotEmpty) {
            return $listFile;
        }

    }

    /**
     * Check and gather info inside directory
     *
     * @param string $dirname directory name
     *
     * @return array
     */
    private function _checkInsideDir($dirname) {
        $o = array(
            'Name' => $dirname,
            'Screenshot' => $this->_getUrlLocation($dirname, $this->fileScreen),
            'Indexfile' => $this->_getUrlLocation($dirname, $this->fileIndex)
        );

        $themedata = $this->getTemplateData($dirname, $this->fileStyle, $this->description);
        $o['Description'] = $themedata['Description'];
        $o['Version'] = $themedata['Version'];
        $o['Author'] = $themedata['Author'];
        return $o;

    }

    private function _getLocation($dirname, array $namelist, $return = false) {
        foreach ($namelist as $fl) {
            if (file_exists2($this->path . SEP . $dirname . SEP . $fl)) {
                return $this->path . SEP . $dirname . SEP . $fl;
            }
        }

        return $return;

    }

    private function _getUrlLocation($dirname, array $namelist, $return = false) {
        foreach ($namelist as $fl) {
            if (file_exists2($this->path . SEP . $dirname . SEP . $fl)) {
                return UW_URL . '/xhtml/' . $dirname . '/' . $fl;
            }
        }

        return $return;

    }

    function getTemplateData($dirname, array $namelist, $return) {
        $namelist[] = $dirname . '.css';
        $temp = preg_replace('/[^\\/\-a-z\s]/i', '', $dirname); //remove any number from string
        if ($temp != $dirname) {
            $namelist[] = $temp . '.css';
        }

        $o = $this->_getLocation($dirname, $namelist);
        if ($o == false) {
            foreach ($this->pathStyle as $pathStyle) {
                $o = $this->_getLocation($dirname . SEP . $pathStyle, $namelist);
                if ($o !== false) {
                    break;
                }
            }
        }

        if ($o) {
            return get_theme_data($o);
        }

        return $return;

    }

}

