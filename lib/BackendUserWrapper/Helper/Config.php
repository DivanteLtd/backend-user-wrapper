<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */


namespace BackendUserWrapper\Helper;

/**
 * Class Config
 * @package BackendUserWrapper\Helper
 */
class Config
{

    const CONFIG_FILENAME = "backenduserwrapper.php";

    /**
     * Gets config from file
     * @return \Zend_Config
     */
    public function getConfig()
    {
        if (file_exists($this->getConfigFilePath())) {
            $config = new \Zend_Config(include($this->getConfigFilePath()), true);
        } else {
            $config = new \Zend_Config(array(
                "className" => "User"
            ), true);
        }

        return $config;
    }

    /**
     * @param \Zend_Config $config
     * @return \Zend_Config
     */
    public function saveConfig(\Zend_Config $config)
    {
        \Pimcore\File::putPhpFile($this->getConfigFilePath(), to_php_data_file_format($config->toArray()));

        return $config;
    }

    /**
     * @return bool
     */
    public function verifyConfig()
    {
        if (!file_exists($this->getConfigFilePath())) {
            return false;
        }

        if (!$this->getConfig()) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getConfigFilePath()
    {
        return PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/" . self::CONFIG_FILENAME;
    }
}
