# CHANGELOG

## 4.1.0

Allow to configure the property of SymfonyUserProvider

## 4.0.1

Fix deprecation for symfony/config 4.2+

## 4.0.0

* UID feature is now called Request id (#4)
* Rename namespace from Hexanet/Common/ to TheRedDot/ (#12)
* Rename ApacheUniqueIdProvider to ServerRequestIdProvider (#16)
* The following classes are now finals:
  * `TheRedDot\MonologExtraBundle\Provider\RequestId\ServerRequestIdProvider`
  * `TheRedDot\MonologExtraBundle\Provider\RequestId\UniqidProvider`
  * `TheRedDot\MonologExtraBundle\Provider\Session\SymfonySessionIdProvider`
  * `TheRedDot\MonologExtraBundle\Provider\User\SymfonyUserProvider`
