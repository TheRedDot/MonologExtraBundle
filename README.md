# MonologExtraBundle

[![Build Status](https://api.travis-ci.org/TheRedDot/MonologExtraBundle.svg)](http://travis-ci.org/TheRedDot/MonologExtraBundle) 	[![Total Downloads](https://poser.pugx.org/TheRedDot/monolog-extra-bundle/downloads.png)](https://packagist.org/packages/TheRedDot/monolog-extra-bundle) [![Latest stable Version](https://poser.pugx.org/TheRedDot/monolog-extra-bundle/v/stable.png)](https://packagist.org/packages/TheRedDot/monolog-extra-bundle)

Symfony bundle with extra processors and logger to log request/response.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require thereddot/monolog-extra-bundle
```

### Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require thereddot/monolog-extra-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new TheRedDot\MonologExtraBundle\TheRedDotMonologExtraBundle(),
        );
        // ...
    }

    // ...
}
```

## Usage

### Processors

The bundle provides several processors:

* User
* Session id
* Request id
* Additions

#### User

The *UserProcessor* add data about the current user in each log entry.

```yaml
the_red_dot_monolog_extra:
    processor:
        user: true
```

The default provider `SymfonyUserProvider` returns:
* anonymous when no user is logged
* the username of the current logged user
* cli

You can customize the provider to replace the username by another property :

```yaml
    TheRedDot\MonologExtraBundle\Provider\User\SymfonyUserProvider:
        arguments:
            $propertyName: myCustomProperty
```

You can create your own provider by creating a service that implements *TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface*.

```yaml
the_red_dot_monolog_extra:
    provider:
        user: your_own_provider_service_id
```

#### Session id

Add the session id in each log entry.

```yaml
the_red_dot_monolog_extra:
    processor:
        session_id: true
```

You can create your own provider by creating a service that implements *TheRedDot\MonologExtraBundle\Provider\Session\SessionIdProviderInterface*.

```yaml
the_red_dot_monolog_extra:
    provider:
        session_id: your_own_provider_service_id
```

#### Request id

Add the request id for the request in each log entry.

```yaml
the_red_dot_monolog_extra:
    processor:
        request_id: true
```

The bundle comes with 2 providers:

* UniqidProvider (default): use `uniqid`
* ServerRequestIdProvider: get from `$_SERVER`
  * you need to pass the name of a field of `$_SERVER`, example for [*mod_unique_id*](https://httpd.apache.org/docs/2.4/mod/mod_unique_id.html) of Apache: `UNIQUE_ID`.

You can create your own provider by creating a service that implements *TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface*.

```yaml
the_red_dot_monolog_extra:
    provider:
        request_id: your_own_provider_service_id
```

#### Additions

Add custom data in each log entry.

```yaml
the_red_dot_monolog_extra:
    processor:
        additions:
            type: symfony
            application: the best symfony application
            locale: "%locale%"
            environment: "%kernel.environment%"
```

### Loggers

#### On request

Create a log entry with the request data.

#### On response

Create a log entry with the response data.

#### On console exception

Create a log entry when an exception occurs in console.

#### Add request id to response

Add the request id of the previous processor in the response headers.

```
HTTP/1.1 302 Found
X-Request-ID: 57c5f5e842b10
```

## Configuration reference

[Configuration reference](doc/configuration_reference.md) for a reference on the available configuration options.

## Credits

Forked from [Hexanet/MonologExtraBundle](https://github.com/Hexanet/MonologExtraBundle).

## License

[MonologExtraBundle](https://github.com/TheRedDot/MonologExtraBundle) is licensed under the [MIT license](LICENSE).
