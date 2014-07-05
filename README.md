Sangkilbiz3 ERP
===========

REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the application using the following command:

~~~
php composer.phar create-project --prefer-dist --stability=dev sangkil/sangkilbiz3 sangkilbiz3
~~~


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. Create a new database and adjust the `components['db']` configuration in `app/config/common-local.php` accordingly.
2. Apply migrations with console command `yii migrate`. This will create tables needed for the application to work.
3. Set document roots of your Web server:

- for sangkilbiz `/path/to/yii-application/app/web/` and using the URL `http://sangkilbiz/`

To login into the application, you need to first sign up, with any of your email address, username and password.
Then, you can login into the application with same email address and password at any time.

This appcilation require other extension that need special treatment. Please read documentation of the extension. They are
[mdmsoft/yii2-admin](https://github.com/mdmsoft/yii2-admin) and [mdmsoft/yii2-autonumber](https://github.com/mdmsoft/yii2-admin)
