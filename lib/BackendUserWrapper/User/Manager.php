<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */

namespace BackendUserWrapper\User;

use BackendUserWrapper\Helper\Config;
use BackendUserWrapper\Helper\UserHelper;
use Pimcore\Model\User;
use Pimcore\Tool;
use Pimcore\Tool\Authentication;
use Pimcore\Translate;

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
            "password" => uniqid(),
            "active" => $userObject->isPublished()
        ]);
        $userObject->setUser($user->getId());
        $userObject->save();

        self::updateUser($userObject, $user);

        $configHelper = new Config();
        $uri = $configHelper->getConfig()->adminUrl;
        $token = Authentication::generateToken(trim($userObject->getUsername()), $user->getPassword());
        $loginUrl = $uri . "/admin/login/login/?username=" . trim($userObject->getUsername()) . "&token=" . $token . "&reset=true";

        $t = new \Zend_View_Helper_Translate();
        $mail = Tool::getMail([$user->getEmail()], $t->translate("account_creation_subject"));
        $mail->setIgnoreDebugMode(true);
        $mail->setBodyText($t->translate("account_creation_message")."\r\n\r\n" . $loginUrl);
        $mail->send();
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

        $roles = UserHelper::getRoles();

        /** @var User\Role $role */
        foreach ($roles->getItems() as $role) {
            if($userObject->{"get".$role->getName()}()) {
                $rolesArray[] = $role->getId();
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
