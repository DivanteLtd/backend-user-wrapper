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

        $json = '{
            "fieldtype":"checkbox",
            "defaultValue":0,
            "queryColumnType":"tinyint(1)",
            "columnType":"tinyint(1)",
            "phpdocType":"boolean",
            "name":"chkbxname",
            "title":"chkbxname",
            "tooltip":"",
            "mandatory":false,
            "noteditable":false,
            "index":false,
            "locked":false,
            "style":"",
            "permissions":null,
            "datatype":"data",
            "relationType":false,
            "invisible":false,
            "visibleGridView":false,
            "visibleSearch":false
        }';

        $roles = [];
        if (is_array($list->getItems())) {
            foreach ($list->getItems() as $item) {
                $role = json_decode ($json);
                $role->name = $item->getName();
                $role->title = $item->getName();
                $roles[] = $role;
            }
        }

        return json_encode($roles);
    }

    /**
     * @return \Pimcore\Model\User\Role\Listing
     */
    public static function getRoles()
    {
        $list = new \Pimcore\Model\User\Role\Listing();
        $list->setCondition("`type` = ?", ["role"]);
        $list->load();

        return $list;
    }

}
