Defines the class `WordPressTestCase` to do PHPUnit tests in WordPress, with logging support.

# Usage

1. Install the package with `composer require idearia/wp-tests --dev`.
1. Create a test by extending `Idearia\WpTests\WordPressTestCase`.
1. Launch `vendor/bin/phpunit` to run your tests.

# Example class

In *examples/WordPressTest.php* you can find an example of a test which implements `WordPressTestCase`. In this test, we create, fetch and delete a WordPress post.

# Example phpunit.xml

In *examples/phpunit.example.xml* you can find an example of a PHPUnit configuration file with all the avilable options.

# Logging

The class `WordPressTestCase` implement a simple logger trait:

- To log a messag to file, call `self::log( $message )`.
- The file will be named after the test class and placed in the subfolder *tests/logs*. **Important**: if you use the logger, make sure this folder exists!
- Customize the folder with the `logsPath` environment variable (see below).
- You can also customize the filename, or even choose a different stream. For these advanced uses, see the class documentation.

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
If you use a relative path, please note that the reference folder will be *vendor/idearia/wp-tests*.

To set `wordPressPath` in *phpunit.xml*:

```xml
<php>
    <env name="wordPressPath" value="/path/to/wordpress/wp-load.php"/>
</php>
```

# Custom folder for the logs

By default, the log files will be placed in the *tests/logs* folder; set the `logsPath` environment variable to use a different folder.
If you use a relative path, please note that the reference folder will be *vendor/idearia/wp-tests*.

To set `logsPath` in *phpunit.xml*:

```xml
<php>
    <env name="logsPath" value="/path/to/wordpress/wp-load.php"/>
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
- Make logsPath relative to where phpunit.xml is
- Make wordPressPath relative to where phpunit.xml is
