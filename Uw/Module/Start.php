<?php

class Uw_Module_Start {

    /**
     * First time flag
     * @var bool
     */
    private $isFirstTime = true;

    /**
     * Current theme opt
     * @var array
     */
    private $opt = array();
    private $filename = 'firsttime.ini';

    public function init(Uw_Config_Data $config, Uw_Config_Read $reader, $opt,
        $filename =''
    ) {
        if ($opt) {
            $this->isFirstTime = false;
        } else {
            $this->isFirstTime = true;
            $htaccess = new Uw_Module_Htaccess();
            if ($htaccess->setHtaccessFile()) {
                if ($filename) {
                    $this->filename = $filename;
                }
            }
 
            $opt = $reader->getOutput($this->filename);
            $opt = $reader->saveConfig($opt); //saving current config into option
        }

        if ($opt) {
            $config->sets($opt);
        }
        return $config;

    }

}