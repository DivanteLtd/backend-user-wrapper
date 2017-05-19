<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace BackendUserWrapper\User;

use Pimcore\Model\User;

/**
 * Class Manager
 *
 * @package BackendUserWrapper\User
 */
class Manager
{
    /**
     * @param \Pimcore\Model\Object\BackendUser $userObject
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
     * @param \Pimcore\Model\Object\BackendUser $userObject
     */
    protected static function createUser($userObject)
    {
        $user = User::create([
            "parentId" => 0,
            "name" => trim($userObject->getUsername()),
            "password" => "",
            "active" => $userObject->isPublished()
        ]);

        $userObject->setUser($user->getId());
        $userObject->save();
        self::updateUser($userObject, $user);
    }

    /**
     * @param \Pimcore\Model\Object\BackendUser $userObject
     * @param User $user
     */
    protected static function updateUser($userObject, User $user)
    {
        $user->setActive($userObject->isPublished());
        $user->setName($userObject->getUsername());
        $user->setEmail($userObject->getEmail());
        $user->setFirstname($userObject->getFirstname());
        $user->setLastname($userObject->getLastname());

        $roles = $userObject->getUserRoles();

        $rolesArray = [];
        if (is_array($roles)) {
            foreach ($roles as $rule) {
                $rolesArray[] = User\Role::getByName($rule)->getId();
            }
        }

        $user->setRoles($rolesArray);

        $user->save();
    }

    /**
     * @param \Pimcore\Model\Object\BackendUser $userObject
     */
    public static function deleteUser($userObject)
    {
        $user = User::getByName($userObject->getUsername());
        $user->delete();
    }
}
