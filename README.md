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
1. Create some tests, based on either SimpleTest.php or WordPressTest.php, and run them with `composer run test`.