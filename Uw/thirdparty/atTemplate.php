<?php

/**
 * Atrim Framework
 *
 * PHP version 5
 *
 * @category  Atrim
 * @package   Atrim_Core_Model
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Atrim_Core_Model_Resource_Template_AtTemplate
 *
 * Internal version 1.0.1 - used on outside framework. Originally used in
 * AtRim Framework and outside used firstly on HtmlSlicerDisplay theme
 *
 * @category   Atrim
 * @package    Atrim_Core_Model
 * @subpackage Atrim_Core_Model_Resource_Template_GrTemplate
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 * @todo       buat penjelasan cara praktis penggunaannya
 */
class Atrim_Core_Model_Resource_Template_AtTemplate
{

    /**
     * Path of template dir. need to build meaningful but also secret error message.
     * If we only print $_resourcePath, when a file is missing then we're going
     * to have security problem
     *
     * @var string
     */
    private $_PATHGFRHOME;

    /**
     * Path of resource/template path
     *
     * @var string
     */
    private $_resourcePath;

    /**
     * Path of templating file that going to be inclure and process on templating
     *
     * @var string
     */
    private $_file;

    /**
     * Filter object handle
     *
     * Object must have processFilter() method
     *
     * @var Atrim_Core_Model_Library_Filter_glFilter
     */
    public $gFilter;

    /**
     * Filter object mehod name
     *
     * default is processFilter()
     */
    public $gFilterMethod = 'processFilter';

    /**
     * Constractor
     *
     * @param Atrim_Core_Model_Library_Request_GRequestBox $gRequestBox handler consist of path
     */
    function __construct(Atrim_Core_Model_Library_Request_GRequestBox $gRequestBox = NULL)
    {
        if ($gRequestBox) {
            //$filterMethod
            $this->gFilter = $gRequestBox->gFilter;
            $this->_resourcePath = $gRequestBox->_PATHGFRRESOURCEDIR . SEP . 'Template';
            $this->_PATHGFRHOME = $gRequestBox->_PATHGFRHOME;
        }

    }

    /**
     * Reconstrcut class properties
     *
     * @param array $args class argument
     */
    function reConstruct(array $args) {
        extract($args);

        $this->gFilter = $filterObj;
        $this->gFilterMethod = $filterMethod;
        $this->_resourcePath = $resourcePath;
        $this->_PATHGFRHOME = $homePath;

    }

    /**
     * Get template
     *
     * @param string $fileName      filename
     * @param array  $args          will extracted variable needed by templating process
     * @param array  $defaultFilter list methodname of $gFilter object
     *
     * @return HTML
     */
    function getTemplate($fileName, array $args,
        array $defaultFilter = array('filterNonChar')
    ) {
        if (empty($fileName)
            OR !file_exists($this->_resourcePath . SEP . $fileName)
        ) {
            $filepath = $this->_resourcePath . SEP . $fileName;
            return $this->_getMissingFileErrMsg($filepath);
        }

        $this->_template_file = $fileName;
        $this->_file = $this->_resourcePath . SEP . $fileName;

        if (is_a($this->gFilter, 'Atrim_Core_Model_Library_Filter_glFilter')) {
            if (!empty($defaultFilter)) {
                if ($this->processFilter) {
                    /**
                     * call filtering method from filter object
                     */
                    $processFilter = $this->processFilter;
                    $args = $this->gFilter->$processFilter(&$args, $defaultFilter);
                }
            }
        }

        return $this->_doTemplating($args);

    }

    /**
     * Display static template output from html file
     *
     * @param string $fileName the name of file in $_resourcePath
     *
     * @return void
     */
    function getTemplateStatic($fileName)
    {
        if (empty($fileName)
            OR !file_exists($this->_resourcePath . SEP . 'static' . SEP . $fileName)
        ) {
            $filepath = $this->_resourcePath . SEP . 'static' . SEP . $fileName;
            return $this->_getMissingFileErrMsg($filepath);
        }

        $this->_template_file = $fileName;
        $this->_file = $this->_resourcePath . SEP . 'static' . SEP . $fileName;
        include $this->_file;

    }

    /**
     * Do templating process on $_file property
     *
     * @param array $args will extracted variable needed by templating process
     *
     * @return string
     */
    private function _doTemplating(array $args)
    {
        ob_start();
        extract($args);
        include $this->_file;
        return ob_get_clean();

    }

    /**
     * Return missing file error msg
     *
     * @param string $filepath the path of missing file. consist complete location of filename
     *
     * @return void
     */
    private function _getMissingFileErrMsg($filepath)
    {
        $securePath = str_replace($this->_PATHGFRHOME, '', $filepath);
        return 'Missing Static template file : in ' . $securePath . '</br>';

    }

}