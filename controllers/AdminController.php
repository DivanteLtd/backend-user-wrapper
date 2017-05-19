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

        if ($className) {
            $config->className = $className;
            $configHelper->saveConfig($config);
        }

        $this->view->className = $config->className;
    }
}
