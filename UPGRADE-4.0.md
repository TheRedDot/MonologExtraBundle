# UPGRADE to 4.0

* Rename bundle class from `Hexanet\Common\MonologExtraBundle\HexanetMonologExtraBundle` to `TheRedDot\MonologExtraBundle\TheRedDotMonologExtraBundle`
* Rename the package config from `hexanet_monolog_extra` to `the_red_dot_monolog_extra`
* The UID feature has been renamed to Request-id

Before:

```yaml
hexanet_monolog_extra:
    processor:
        uid: true
    provider:
        uid: Hexanet\Common\MonologExtraBundle\Provider\RequestId\ApacheUniqueIdProvider
    logger:
        add_uid_to_response: true
```

After:

```yaml
the_red_dot_monolog_extra:
    processor:
        request_id: true
    provider:
        request_id: TheRedDot\MonologExtraBundle\Provider\RequestId\ServerRequestIdProvider
    logger:
        add_request_id_to_response: true
```

* The provider `ApacheUniqueIdProvider` is replaced by `ServerRequestIdProvider`
  * For user of  [*mod_unique_id*](https://httpd.apache.org/docs/2.4/mod/mod_unique_id.html) of Apache, you needs to pass `UNIQUE_ID`.
