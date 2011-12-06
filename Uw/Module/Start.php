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
        $inInifile = $reader->getOutput($this->filename);
        if ($opt) {
            /**
             * see http://wp.uwiuw.com/issue-compability-theme-option-version-0-0-1-ke-0-0-2/
             */
            if (TRUE === $this->_isNeedUpgrade($opt, $inInifile)) {
                $opt = $reader->saveConfig($inInifile);
            }
        } else {
            //first time
            $this->_rebuildHtaccess();
            $opt = $reader->saveConfig($inInifile); //saving current config into option
        }

        if ($opt) {
            $config->sets($opt);
        }
 
        return $config;

    }

    private function _rebuildHtaccess() {
        $htaccess = new Uw_Module_HtAccess();
        return $htaccess->setHtaccessFile();

    }

    /**
     * Processnya bila pada data di db itu ternyata ada missingkey,lalu bila
     * missing key itu ditemukan maka nilainya yg ada diconfig akan ditansfer ke 
     * 
     * @param array $inDb byreference. data yg ada di database
     * @param array $inIniFile by reference. config yg berada dalam file ini
     * @return bool
     */
    private function _isNeedUpgrade($inDb, &$inIniFile) {
        if (empty($inDb)) {
            return true;
        }

        foreach ($inIniFile['mandatory'] as $k) {
            if (false === array_key_exists($k, $inDb)) {
                $missingKey[] = $k;
                $is_true = true;
            }
        }

        if ($is_true) {
            foreach ($missingKey as $k) {
                $inDb[$k] = $inIniFile[$k];
            }
            $inIniFile = $inDb;

            return true;
        }

        return False;

    }

}