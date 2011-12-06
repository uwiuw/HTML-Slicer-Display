<?php

class Uw_Module_Start {

    /**
     * Current theme opt
     * @var array
     */
    private $opt = array();

    /**
     * Config File name (without absolute path)
     * @var string
     */
    private $filename = 'firsttime.ini';

    public function init(Uw_Config_Data $config, Uw_Config_Read $reader, $opt,
        $filename =''
    ) {

        if ($filename) {
            $this->filename = $filename;
        }

        //if $opt not empty, then it's not the first time
        if ($opt) {
            /**
             * see http://wp.uwiuw.com/issue-compability-theme-option-version-0-0-1-ke-0-0-2/
             */
            $inInifile = $reader->getOutput($this->filename);
            if (TRUE === $this->_isNeedToUpgrade($opt, $inInifile)) {
                $opt = $reader->saveConfig($inInifile);
            }
        } else {
            //first time 
            $this->_rebuildHtaccess();
            $opt = $reader->getOutput($this->filename);
            $opt = $reader->saveConfig($opt); //saving current config into option
        }

        if ($opt) {
            $config->sets($opt);
        }
        return $config;

    }

    private function _rebuildHtaccess() {
        $htaccess = new Uw_Module_Htaccess();
        return $htaccess->setHtaccessFile();

    }

    private function _isNeedToUpgrade($inDb, $inIniFile) {
        $mandatory = $inIniFile['mandatory'];
        
        $hasildebug = print_r($mandatory, TRUE);
        echo "\n" . '<pre style="font-size:14px"><hr>' . '$hasildebug ' . htmlentities2($hasildebug) . '</pre>';
        
        
        return False;
    }

}