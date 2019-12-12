<?php

namespace TheRedDot\MonologExtraBundle\Provider\User;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class SymfonyUserProvider implements UserProviderInterface
{
    /**
     * User for anonymous.
     */
    private const USER_ANONYMOUS = 'anonymous';

    /**
     * Value for user when we are in cli.
     */
    private const USER_CLI = 'cli';

    /**
     * @var TokenStorageInterface|null
     */
    private $tokenStorage;

    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $propertyName;

    public function __construct(
        TokenStorageInterface $tokenStorage = null,
        string $className = UserInterface::class,
        string $propertyName = 'username',
        PropertyAccessorInterface $propertyAccessor = null
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->propertyAccessor = $propertyAccessor ?? PropertyAccess::createPropertyAccessor();
        $this->className = $className;
        $this->propertyName = $propertyName;
    }

    public function getUser(): string
    {
        $user = self::USER_ANONYMOUS;

        if (null !== $this->tokenStorage) {
            $token = $this->tokenStorage->getToken();
            if (null !== $token && $token->getUser() instanceof $this->className) {
                $user = $this->propertyAccessor->getValue($token->getUser(), $this->propertyName);
            }
        }

        if ('cli' === php_sapi_name()) {
            $user = self::USER_CLI;
        }

        return $user;
    }
}
