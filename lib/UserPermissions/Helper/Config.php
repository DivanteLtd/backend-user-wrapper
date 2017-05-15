<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 10.05.17
 * Time: 14:06
 */

namespace UserPermissions\Helper;

/**
 * Class Config
 * @package UserPermissions\Helper
 */
class Config
{

    const CONFIG_FILENAME = "userpermissions.php";

    /**
     * Gets config from file
     * @return \Zend_Config
     */
    public function getConfig()
    {

        if (file_exists(PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/" . self::CONFIG_FILENAME)) {
            $config = new \Zend_Config(include(PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/userpermissions.php"), true);
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
        $configFile = PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/" . self::CONFIG_FILENAME;
        \Pimcore\File::putPhpFile($configFile, to_php_data_file_format($config->toArray()));

        return $config;
    }

    /**
     * @return bool
     */
    public function verifyConfig()
    {

        if (!file_exists(PIMCORE_CUSTOM_CONFIGURATION_DIRECTORY . "/" . self::CONFIG_FILENAME)) {
            return false;
        }

        if (!$this->getConfig()) {
            return false;
        }

        return true;
    }
}
