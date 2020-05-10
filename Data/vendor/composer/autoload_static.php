<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1e3d0ad44967e0d7085d2e7d3dde8786
{
    public static $files = array(
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '9c67151ae59aff4788964ce8eb2a0f43' => __DIR__ . '/..' . '/clue/stream-filter/src/functions_include.php',
        '8cff32064859f4559445b89279f3199c' => __DIR__ . '/..' . '/php-http/message/src/filters.php',
        '25072dd6e2470089de65ae7bf11d3109' => __DIR__ . '/..' . '/symfony/polyfill-php72/bootstrap.php',
        'f598d06aa772fa33d905e87be6398fb1' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/bootstrap.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array(
        'S' =>
            array(
                'Symfony\\Polyfill\\Php72\\' => 23,
                'Symfony\\Polyfill\\Mbstring\\' => 26,
                'Symfony\\Polyfill\\Intl\\Idn\\' => 26,
                'Symfony\\Component\\Mime\\' => 23,
                'Symfony\\Component\\HttpFoundation\\' => 33,
            ),
        'P' =>
            array(
                'Psr\\Http\\Message\\' => 17,
                'Psr\\Http\\Client\\' => 16,
            ),
        'O' =>
            array(
                'Omnipay\\Stripe\\' => 15,
                'Omnipay\\Common\\' => 15,
            ),
        'M' =>
            array(
                'Money\\' => 6,
            ),
        'H' =>
            array(
                'Http\\Promise\\' => 13,
                'Http\\Message\\' => 13,
                'Http\\Discovery\\' => 15,
                'Http\\Client\\' => 12,
                'Http\\Adapter\\Guzzle6\\' => 21,
            ),
        'G' =>
            array(
                'GuzzleHttp\\Psr7\\' => 16,
                'GuzzleHttp\\Promise\\' => 19,
                'GuzzleHttp\\' => 11,
            ),
        'C' =>
            array(
                'Clue\\StreamFilter\\' => 18,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'Symfony\\Polyfill\\Php72\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/polyfill-php72',
            ),
        'Symfony\\Polyfill\\Mbstring\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
            ),
        'Symfony\\Polyfill\\Intl\\Idn\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/polyfill-intl-idn',
            ),
        'Symfony\\Component\\Mime\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/mime',
            ),
        'Symfony\\Component\\HttpFoundation\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/http-foundation',
            ),
        'Psr\\Http\\Message\\' =>
            array(
                0 => __DIR__ . '/..' . '/psr/http-message/src',
            ),
        'Psr\\Http\\Client\\' =>
            array(
                0 => __DIR__ . '/..' . '/psr/http-client/src',
            ),
        'Omnipay\\Stripe\\' =>
            array(
                0 => __DIR__ . '/..' . '/omnipay/stripe/src',
            ),
        'Omnipay\\Common\\' =>
            array(
                0 => __DIR__ . '/..' . '/omnipay/common/src/Common',
            ),
        'Money\\' =>
            array(
                0 => __DIR__ . '/..' . '/moneyphp/money/src',
            ),
        'Http\\Promise\\' =>
            array(
                0 => __DIR__ . '/..' . '/php-http/promise/src',
            ),
        'Http\\Message\\' =>
            array(
                0 => __DIR__ . '/..' . '/php-http/message/src',
                1 => __DIR__ . '/..' . '/php-http/message-factory/src',
            ),
        'Http\\Discovery\\' =>
            array(
                0 => __DIR__ . '/..' . '/php-http/discovery/src',
            ),
        'Http\\Client\\' =>
            array(
                0 => __DIR__ . '/..' . '/php-http/httplug/src',
            ),
        'Http\\Adapter\\Guzzle6\\' =>
            array(
                0 => __DIR__ . '/..' . '/php-http/guzzle6-adapter/src',
            ),
        'GuzzleHttp\\Psr7\\' =>
            array(
                0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
            ),
        'GuzzleHttp\\Promise\\' =>
            array(
                0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
            ),
        'GuzzleHttp\\' =>
            array(
                0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
            ),
        'Clue\\StreamFilter\\' =>
            array(
                0 => __DIR__ . '/..' . '/clue/stream-filter/src',
            ),
    );

    public static $classMap = array(
        'Omnipay\\Omnipay' => __DIR__ . '/..' . '/omnipay/common/src/Omnipay.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1e3d0ad44967e0d7085d2e7d3dde8786::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1e3d0ad44967e0d7085d2e7d3dde8786::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1e3d0ad44967e0d7085d2e7d3dde8786::$classMap;

        }, null, ClassLoader::class);
    }
}
