A simple class to use PHPUnit tests in WordPress.

# Usage

1. Copy the *tests* folder and the *phpunit.xml* file in your plugin or theme.
1. Customize the WordPress path in *phpunit.xml*; you can use relative paths.
1. Customize (or remove) the namespaces used in the *tests* folder.
1. Make sure you have PHPUnit intalled: `composer require phpunit/phpunit --dev`.
1. Add this to your composer.json:
    ```
    "scripts": {
        "test": [
            "phpunit --testdox"
        ]
    },
    ```
1. Create some tests, based on either *SimpleTest.php* or *WordPressTest.php*, and run them with `composer run test`.

# Logging

The tests implement a simple logger class:

- To log a messag to file, call `self::log( $message )` within the test class.
- The file will be named after the test class, and placed in the logs subfolder.
- To customize the filename, filepath or choose a different stream, see the class documentation.
