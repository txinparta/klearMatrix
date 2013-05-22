<?php
class KlearMatrix_Model_Field_Map extends KlearMatrix_Model_Field_Abstract
{
    protected $_availableSettings = array(
        'draggable',
        'zoom',
        'width',
        'height',
        'previewZoom',
        'previewWidth',
        'previewHeight',
        'defaultLat',
        'defaultLng',
    );
    
    protected $_defaults = array(
        'previewZoom' => 10,
        'previewWidth' => 80,
        'previewHeight' => 80
    );

    public function _init()
    {
        $this->_js = array(
           "/js/plugins/jquery.gmaps.js",
        );

        $config = $this->_config->getRaw()->source;

        $this->_setConfig($config);
    }

    protected function _setConfig($config)
    {
        if ($config && $config->settings) {

            foreach ($config->settings as $key => $value) {

                $this->_setSetting($key, $value);
            }
        }

        return $this;
    }

    protected function _setSetting($key, $value)
    {
        if ($value instanceof Zend_Config) {

            $value = $value->toArray();
        }

        if (in_array($key, $this->_availableSettings)) {

            $this->_properties[$key] = $value;
        }

        if (! isset($value)) {
            var_dump(debug_backtrace());
        }
        return $this;
    }

    /*
     * Prepara el valor de un campo, después del getter
     */
    public function prepareValue($value)
    {
        $columnName = $this->_column->getDbFieldName();

        $ret = array(
            'address' => $value,
            'lat' => $this->_column->getModel()->{'get' . ucfirst($columnName) . 'Lat'}(),
            'lng' => $this->_column->getModel()->{'get' . ucfirst($columnName) . 'Lng'}(),
            'previewZoom' => (isset($this->_properties['previewZoom'])) ? $this->_properties['previewZoom'] : $this->_defaults['previewZoom'],
            'previewWidth' => (isset($this->_properties['previewWidth'])) ? $this->_properties['previewWidth'] : $this->_defaults['previewWidth'],
            'previewHeight' => (isset($this->_properties['previewHeight'])) ? $this->_properties['previewHeight'] : $this->_defaults['previewHeight'],
        );

        return $ret;
    }
}