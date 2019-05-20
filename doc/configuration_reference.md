# Configuration reference

```yaml
the_red_dot_monolog_extra:

    # add data to extra in each records of log
    processor:

        # add the username of the current user
        user: true

        # add the session id
        session_id: false

        # add request id
        request_id: true

        # add static data
        additions:
            type: symfony
            application: symfony application
            extra_info: blabla
            environment:  "%kernel.environment%"

    logger:
        # log each request
        on_request: true

        # log each response
        on_response: true

        # log each command
        on_command: true

        # log console exception
        on_console_exception: true

        # add request id in the headers of responses
        add_request_id_to_response: true

    # you can change the provider for request id, user and session_id
    provider:
        request_id: TheRedDot\MonologExtraBundle\Provider\RequestId\ApacheUniqueIdProvider

        user: TheRedDot\MonologExtraBundle\Provider\User\SymfonyUserProvider

        session_id: TheRedDot\MonologExtraBundle\Provider\Session\SymfonySessionIdProvider
```
