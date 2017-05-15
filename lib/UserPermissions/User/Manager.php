<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 10.05.17
 * Time: 15:12
 */

namespace UserPermissions\User;

use Pimcore\Model\User;

/**
 * Class Manager
 * @package UserPermissions\User
 */
class Manager
{
    /**
     * @param \Pimcore\Model\Object\User $userObject
     */
    public static function processUser($userObject)
    {
        $user = User::getByName($userObject->getUsername());
        if (!$user) {
            self::createUser($userObject);
        } else {
            self::updateUser($userObject, $user);
        }
    }

    /**
     * @param \Pimcore\Model\Object\User $userObject
     */
    protected static function createUser($userObject)
    {
        if ($userObject->isPublished()) {
            $active = true;
        } else {
            $active = false;
        }

        $user = User::create([
            "parentId" => 0,
            "name" => trim($userObject->getUsername()),
            "password" => "",
            "active" => $active
        ]);

        $userObject->setUser($user->getId());
    }

    /**
     * @param \Pimcore\Model\Object\User $userObject
     * @param \Pimcore\Model\User $user
     */
    protected static function updateUser($userObject, User $user)
    {
        if ($userObject->isPublished()) {
            $active = true;
        } else {
            $active = false;
        }

        $user->setActive($active);
        $user->save();
    }
}
