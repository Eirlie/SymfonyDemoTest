Symfony Demo Application
========================

The "Symfony Demo Application" is an update to the default reference application created to show how
to develop Symfony applications following the recommended best practices.

In this update every post has a price in any currency made available by administrator. 
Also administrator can set rate of exchange in connection to rubles. 
To ease this task there is a functionality of importing this information directly from the server of The Central Bank of Russian Federation 

Requirements
------------

  * PHP 5.5.9 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

If unsure about meeting these requirements, download the demo application and
browse the `http://localhost:8000/config.php` script to get more detailed
information.

Installation
------------

The only task need to be done on this stage is installing dependencies via composer.

After you may want to fill database with test data using command:

```bash
$ php app/console doctrine:fixtures:load
```

Usage
-----

For testing functionality you can use the built-in web server:

```bash
$ cd symfony-demo/
$ php app/console server:run
```

This command will start a web server for the Symfony application. Now you can
access the application in your browser at <http://localhost:8000>. You can
stop the built-in web server by pressing `Ctrl + C` while you're in the
terminal.

> **NOTE**
>
> There is no translations for custom tokens of the application. You may want to fill them before actually using it. 
