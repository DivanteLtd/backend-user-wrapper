<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace BackendUserWrapper\Helper;

/**
 * Class User
 * Helper providing User model functions
 * @package BackendUserWrapper\Helper
 */
class UserHelper
{
    /**
     * Gets Pimcore's roles as a json_encoded string
     * @return string
     */
    public static function getRolesString()
    {
        $list = new \Pimcore\Model\User\Role\Listing();
        $list->setCondition("`type` = ?", ["role"]);
        $list->load();

        $roles = [];
        if (is_array($list->getItems())) {
            foreach ($list->getItems() as $item) {
                $role = new \stdClass();
                $role->key = $item->getName();
                $role->value = $item->getName();
                $roles[] = $role;
            }
        }

        return json_encode($roles);
    }
}
