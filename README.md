Defines the class `WordPressTestCase` to run PHPUnit tests in a WordPress installation, with support for logging and multisite.

# Usage

1. Install with `composer require idearia/wp-tests --dev`.
1. Create a test case by extending `Idearia\WpTests\WordPressTestCase`.
1. When you run the test, WordPress will be automatically loaded.

Have a look in the [the example folder](examples). You'll find:

- an [example test](examples/WordPressTest.php) that creates, fetches and deletes a WordPress post;
- an [example phpunit.xml](examples/phpunit.example.xml) file with the available options.

# Logging support

- To log a message to screen, call `self::print( $message )`.
- To log a message to file, call `self::log( $message )`.
- The file will be named after the test class and placed in the subfolder _tests/logs_.
- The log file will reset at each run unless you set `protected static $deleteLogFile = false;` in your test case.
- Customize the log folder via the `logsPath` environment variable.
- For further customizations, please refer to the documentation of the [Loggable trait](https://github.com/coccoinomane/phpunit-log).

# Multisite support

By default, the tests will be run on the main blog.

To run the tests on a different blog, add the `siteUrl` environment variable to your phpunit.xml file:

```xml
<php>
  <env name="siteUrl" value=""/>
</php>
```

Then, you are free to set `siteUrl` the way you see fit:

- In a [dotenv file](https://github.com/vlucas/phpdotenv).
- When you run phpunit: `siteUrl=http://example.com/blog phpunit`.
- At the shell level: `export siteUrl=http://example.com/blog`.
- In your test case setup: `putenv( 'siteUrl=http://example.com/blog' );`.
- Hard-code it in phpunit.xml.

# Custom WordPress path

If your WordPress installation is non-standard, you can specify a custom WordPress path by setting the `wordPressPath` environment variable.
You can use both relative and absolute paths.

To set `wordPressPath` in _phpunit.xml_:

```xml
<php>
    <env name="wordPressPath" value="/path/to/wordpress/"/>
</php>
```
