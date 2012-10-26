<?php
/**
 * FIXME: setConfig y getConfig realmente no tienen nada que ver, habría que darle otra vuelta a eso...
 *
 */
abstract class KlearMatrix_Model_Field_Textarea_Abstract
{

    protected $_config;

    protected $_settings = array();
    protected $_plugin;

    protected $_js = array();
    protected $_css = array();

    public function __construct(Zend_Config $config)
    {
        $this->setConfig($config);
        $this->_setPlugin();
        $this->init();
    }

    public function setConfig(Zend_Config $config)
    {
        $this->_config = new Klear_Model_ConfigParser;
        $this->_config->setConfig($config);
        return $this;
    }

    public function getExtraJavascript()
    {
        return $this->_js;
    }

    public function getExtraCss()
    {
        return $this->_css;
    }

    public function getConfig()
    {
        return array(
            'plugin' => $this->_plugin,
            'settings'=> $this->_settings
        );
    }

    abstract protected function _setPlugin();
}
