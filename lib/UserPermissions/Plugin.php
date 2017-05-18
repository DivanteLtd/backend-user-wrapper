<?php

namespace UserPermissions;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Model\Object\ClassDefinition\Service;
use Pimcore\Model\User\Role;
use UserPermissions\Helper\Config;
use UserPermissions\Helper\User;
use UserPermissions\User\Manager;

/**
 * Class Plugin
 * @package UserPermissions
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
        $configHelper = new \UserPermissions\Helper\Config();
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
        $configHelper = new \UserPermissions\Helper\Config();
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

            $classFile = file_get_contents(PIMCORE_PLUGINS_PATH . "/UserPermissions/user.json");
            $rolesString = User::getRolesString();
            $classFile = str_replace("<<ROLESSTRING>>", $rolesString, $classFile);
            Service::importClassDefinitionFromJson($class, $classFile);
        }

        return true;
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
            return true;
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
