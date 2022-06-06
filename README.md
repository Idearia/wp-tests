A simple class to do PHPUnit tests in WordPress.

# Usage

1. Install the package with `composer require idearia/wp-tests --dev`.
1. Create a test by extending `Idearia\WpTests\WordPressTestCase`.
1. Launch `vendor/bin/phpunit` to run your tests.

# Example test

You can find a complete test example in ./examples/WordPressTest.php.

In this test, we create, fetch and delete a WordPress post.

# Logging

The tests implement a simple logger class:

- To log a messag to file, call `self::log( $message )` within the test class.
- The file will be named after the test class, and placed in the subfolder *tests/logs*. **Important**: make sure this folder exists if you want to use the logger!
- Customize the folder with the `logsPath` environment variable, for example in your *phpunit.xml* .
- You can also customize the filename, or even choose a different stream. For these advanced uses, see the class documentation.

# Multisite support

On a WordPress multisite network, the tests will be run on the main site/blog. You can choose to test against a different site/blog by setting the `blogId` environment variable.

For example, to set the environment variable in *phpunit.xml*:

```xml
<php>
    <env name="blogId" value="20"/>
</php>
```

# Custom WordPress path

If your WordPress installation is non-standard, you can specify a custom WordPress path by setting the `wordPressPath` environment variable.

If you choose to use a relative path, the reference folder will be *vendor/idearia/wp-tests*.

For example, to set the environment variable in *phpunit.xml*:

```xml
<php>
    <env name="wordPressPath" value="/path/to/wordpress/wp-load.php"/>
</php>
```

# Nice output

To run the tests and have the results printed in a nicer way, run `vendor/bin/phpunit --testdox`.

An equivalent but faster way: add this snippet to your composer.json and run `composer run test`:

```
"scripts": {
    "test": [
        "phpunit --testdox"
    ]
}
```

To ass arguments to phpunit, use the notation `composer run test -- arguments`.

# To do

- Add logging to example