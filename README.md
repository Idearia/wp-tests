Defines the class `WordPressTestCase` to do PHPUnit tests in WordPress, and the trait `Loggable` to provide logging support.

The `Loggable` trait can be used in vanilla PHP, without WordPress

# Usage

1. Install the package with `composer require idearia/wp-tests --dev`.
1. Create a test by extending `Idearia\WpTests\WordPressTestCase`.
1. Launch `vendor/bin/phpunit` to run your tests.

# Example class

In [examples/WordPressTest.php](examples/WordPressTest.php) you can find an example of a test which implements `WordPressTestCase`. In this test, we create, fetch and delete a WordPress post.

# Example phpunit.xml

In [examples/phpunit.example.xml](examples/phpunit.example.xml) you can find an example of a PHPUnit configuration file with all the available options.

# Loggable trait

- Add logging capabilities to your class with `use Idearia\WpTests\Loggable`
- To log a messag to file, call `self::log( $message )`
- The file will be named after the test class and placed in the subfolder *tests/logs*
- Customize the subfolder with the `logsPath` environment variable (see below).
- You can also customize the filename and, in general, the output stream: for these advanced uses, see the `Loggable` trait's documentation.
- To delete the log files before each run:
    ```php
    if ( file_exists( self::getLogFilePath() ) ) {
        unlink( self::getLogFilePath() );
    }
    ```

Please note that the `Loggable` trait is already used by `WordPressTestCase`.

# Multisite support

On a WordPress multisite network, the tests will be run on the main site/blog.
You can choose to test against a different site/blog by setting the `blogId` environment variable.

To set `blogId` in *phpunit.xml*:

```xml
<php>
    <env name="blogId" value="20"/>
</php>
```

# Custom WordPress path

If your WordPress installation is non-standard, you can specify a custom WordPress path by setting the `wordPressPath` environment variable.
You can use both relative and absolute paths.

To set `wordPressPath` in *phpunit.xml*:

```xml
<php>
    <env name="wordPressPath" value="/path/to/wordpress/"/>
</php>
```

# Custom folder for the logs

By default, the log files will be placed in the *tests/logs* folder; set the `logsPath` environment variable to use a different folder.
You can use both relative and absolute paths.

To set `logsPath` in *phpunit.xml*:

```xml
<php>
    <env name="logsPath" value="./tests/logs"/>
</php>
```

# Nice output

Run `vendor/bin/phpunit --testdox` to print test results in a nicer way.

Equivalently, you coud add this snippet to composer.json and simply run `composer run test`:

```json
"scripts": {
    "test": [
        "phpunit --testdox"
    ]
}
```

To pass arguments to phpunit, use the notation `composer run test -- arguments`.

# To do

- Add logging to example class
