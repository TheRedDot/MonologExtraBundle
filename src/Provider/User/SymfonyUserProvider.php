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
    public const USER_ANONYMOUS = 'anonymous';

    /**
     * Value for user when we are in cli.
     */
    public const USER_CLI = 'cli';

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
    private $propertyName;

    public function __construct(TokenStorageInterface $tokenStorage = null, PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->tokenStorage = $tokenStorage;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
        $this->propertyName = 'username';
    }

    public function getUser(): string
    {
        $user = self::USER_ANONYMOUS;

        if (null !== $this->tokenStorage) {
            $token = $this->tokenStorage->getToken();
            if (null !== $token && $token->getUser() instanceof UserInterface) {
                $user = $this->propertyAccessor->getValue($token->getUser(), $this->propertyName);
            }
        }

        if ('cli' === php_sapi_name()) {
            $user = self::USER_CLI;
        }

        return $user;
    }

    public function setPropertyName(string $propertyName): void
    {
        $this->propertyName = $propertyName;
    }
}
