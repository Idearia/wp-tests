A simple class to do PHPUnit tests in WordPress.

# Usage

1. Install the package with `composer require idearia/wp-tests --dev`.
1. Add this to your composer.json:
    ```
    "scripts": {
        "test": [
            "phpunit --testdox"
        ]
    },
    ```
1. Create some tests, based on either *./tests/SimpleTest.php* or *.tests/WordPressTest.php*, and run them with `composer run test`.

# Logging

The tests implement a simple logger class:

- To log a messag to file, call `self::log( $message )` within the test class.
- The file will be named after the test class, and placed in the logs subfolder.
- To customize the filename, filepath or choose a different stream, see the class documentation.

# Multisite support

On a WordPress multisite network, the tests will be run on the main site/blog. You can choose to test against a different site/blog by setting the `blogId` variable in your *phpunit.xml*.

For example:

```xml
<php>
    <env name="blogId" value="20"/>
</php>
````

# Custom WordPress path

If your WordPress installation is non-standard, you can specify a custom WordPress path by setting the `wordPressPath` variable in your *phpunit.xml*.

If you choose to use a relative path, the reference folder will be *vendor/idearia/wp-tests*.

For example:

```xml
<php>
    <env name="wordPressPath" value="path/to/wordpress/wp-load.php"/>
</php>
````
