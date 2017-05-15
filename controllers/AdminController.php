<?php

/**
 * Class UserPermissions_AdminController
 */
class UserPermissions_AdminController extends \Pimcore\Controller\Action\Admin
{
    /**
     * Index Action - saves config
     */
    public function indexAction()
    {
        $configHelper = new \UserPermissions\Helper\Config();
        $config = $configHelper->getConfig();
        $className =  $this->getParam("className");

        if ($className) {
            $config->className = $className;
            $configHelper->saveConfig($config);
        }

        $this->view->className = $config->className;
    }
}
