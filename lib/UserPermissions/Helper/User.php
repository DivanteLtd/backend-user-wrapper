<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 18.05.17
 * Time: 15:09
 */

namespace UserPermissions\Helper;

/**
 * Class User
 * Helper providing User model functions
 * @package UserPermissions\Helper
 */
class User
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
