<?php

abstract class AbstractPdfCrypto
{
    /**
     * Instance of CakePdf class
     *
     * @var CakePdf
     */
    protected $_Pdf = null;

    /**
     * Configurations
     *
     * @var array
     */
    protected $_config = [];

    /**
     * Constructor
     *
     * @param CakePdf $pdf
     */
    public function __construct(CakePdf $pdf)
    {
        $this->_Pdf = $pdf;
    }

    /**
     * Implement in subclass to return raw pdf data.
     *
     * @param string $data
     * @return string
     */
    abstract public function encrypt($data);

    /**
     * Implement in subclass.
     *
     * @return bool
     */
    abstract public function permissionImplemented($permission);

    /**
     * Set the config
     *
     * @param mixed $config Null, string or array. Pass array of configs to set.
     * @return mixed Returns Returns config value if $config is string, else returns config array.
     */
    public function config($config = null)
    {
        if (is_array($config)) {
            $this->_config = $config;
        } elseif (is_string($config)) {
            if (!empty($this->_config[$config])) {
                return $this->_config[$config];
            }

            return false;
        }

        return $this->_config;
    }
}
