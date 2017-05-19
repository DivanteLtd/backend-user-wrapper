<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace BackendUserWrapper;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Model\Object\ClassDefinition\Service;
use Pimcore\Model\User\Role;
use BackendUserWrapper\Helper\Config;
use BackendUserWrapper\Helper\User;
use BackendUserWrapper\Helper\UserHelper;
use BackendUserWrapper\User\Manager;

/**
 * Class Plugin
 * @package BackendUserWrapper
 */
class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    /**
     * Initialize plugin
     */
    public function init()
    {
        parent::init();
        \Pimcore::getEventManager()->attach("object.postUpdate", [$this, "handleObject"]);
        \Pimcore::getEventManager()->attach("object.postDelete", [$this, "deleteObject"]);
    }

    /**
     * @param Event $event
     */
    public function handleObject($event)
    {
        $object = $event->getTarget();
        $configHelper = new \BackendUserWrapper\Helper\Config();
        if ($object->getClassName() == $configHelper->getConfig()->className) {
            Manager::processUser($object);
        }
    }

    /**
     * @param Event $event
     */
    public function deleteObject($event)
    {
        $object = $event->getTarget();
        $configHelper = new \BackendUserWrapper\Helper\Config();
        if ($object->getClassName() == $configHelper->getConfig()->className) {
            Manager::deleteUser($object);
        }
    }

    /**
     * Creates class
     * @return bool|string
     */
    public static function install()
    {
        $configHelper = new Config();
        if (!$configHelper->verifyConfig()) {
            return "Plugin is not yet confgured!";
        }

        $config = $configHelper->getConfig();

        $class = \Pimcore\Model\Object\ClassDefinition::getByName($config->className);

        if (!$class) {
            $class = \Pimcore\Model\Object\ClassDefinition::create(array(
                "name" => $config->className
            ));

            $classFile = file_get_contents(PIMCORE_PLUGINS_PATH . "/BackendUserWrapper/user.json");
            $rolesString = UserHelper::getRolesString();
            $classFile = str_replace("<<ROLESSTRING>>", $rolesString, $classFile);
            Service::importClassDefinitionFromJson($class, $classFile);
        }

        return "BackendUser plugin has been installed.";
    }

    /**
     * @return bool
     */
    public static function uninstall()
    {
        $configHelper = new Config();
        $config = $configHelper->getConfig();

        $class = \Pimcore\Model\Object\ClassDefinition::getByName($config->className);
        if (!$class) {
            return false;
        } else {
            $class->delete();
            return "BackendUser Plugin has been uninstalled.";
        }
    }

    /**
     * @return bool
     */
    public static function isInstalled()
    {
        $configHelper = new Config();
        if (!$configHelper->verifyConfig()) {
            return false;
        }

        $config = $configHelper->getConfig();

        $class = \Pimcore\Model\Object\ClassDefinition::getByName($config->className);
        if (!$class) {
            return false;
        }

        return true;
    }
}
