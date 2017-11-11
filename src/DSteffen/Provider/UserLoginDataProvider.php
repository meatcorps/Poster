<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DSteffen\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Wrapper for handling security.firewall users. It's connects the security.firewall to the db UserManager.
 *
 * @author Dennis Steffen
 */
class UserLoginDataProvider implements UserProviderInterface
{
    /**
     * Main Silex app so we can access it from other functions
     * @var \Silex\Application 
     */
    private $app;
    /**
     * The User DB table controller
     * @var \DSteffen\Model\Manager\UserManager 
     */
    private $userController;

    /**
     * Setup the class so private fields are set for other functions.
     * 
     * @param \Silex\Application $app
     */
    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
        $this->userController = $app["db.user"];
    }

    /**
     * Search for the user by name. Creates a firewall user when there is a match. Please check the symphony manual for more information
     * 
     * @param string $username
     * @return User
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userController->getUser($username);
 
        if (count($user) == 0) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        
        return new User($user[0]['user'], $user[0]['password'], explode(',', $user[0]['roles']), true, true, true, true);
    }

    /**
     * Reloads a user. Please check the symphony manual for more information
     * 
     * @param UserInterface $user
     * @return User
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Check of it's the user class is supported. Please check the symphony manual for more information
     * 
     * @param type $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}