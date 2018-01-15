<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita742fdc5880a40acb8aa5f7ac1ad4672
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita742fdc5880a40acb8aa5f7ac1ad4672::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita742fdc5880a40acb8aa5f7ac1ad4672::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita742fdc5880a40acb8aa5f7ac1ad4672::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}