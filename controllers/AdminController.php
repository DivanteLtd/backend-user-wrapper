<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */


/**
 * Class UserPermissions_AdminController
 *
 * @package BackendUserWrapper
 */
class BackendUserWrapper_AdminController extends \Pimcore\Controller\Action\Admin
{
    /**
     * Index Action - saves config
     */
    public function indexAction()
    {
        $configHelper = new \BackendUserWrapper\Helper\Config();
        $config = $configHelper->getConfig();
        $className = $this->getParam("className");
        $adminUrl = $this->getParam("adminUrl");
        $reload = $this->getParam("reload");

        if ($className) {
            $config->className = $className;
            $config->adminUrl = $adminUrl;
            $configHelper->saveConfig($config);
            $this->view->saved = true;
        }

        $this->view->className = $config->className;
        $this->view->adminUrl = $adminUrl;
        $this->view->reload = $reload;
    }

    /**
     * @return mixed
     */
    public function reloadRolesAction()
    {
        $configHelper = new \BackendUserWrapper\Helper\Config();
        $config = $configHelper->getConfig();
        $class = \Pimcore\Model\Object\ClassDefinition::getByName($config->className);
        $classFile = file_get_contents(PIMCORE_PLUGINS_PATH . "/BackendUserWrapper/user.json");
        $rolesString = \BackendUserWrapper\Helper\UserHelper::getRolesString();
        $classFile = str_replace("<<ROLESSTRING>>", $rolesString, $classFile);
        \Pimcore\Model\Object\ClassDefinition\Service::importClassDefinitionFromJson($class, $classFile);
        $this->redirect("/plugin/BackendUserWrapper/admin/index?reload=true");
    }
}
