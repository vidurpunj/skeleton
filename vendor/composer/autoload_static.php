<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite138ae397c557b28c9a5a96e37a6e241
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zendframework/library/Zend',
        ),
    );

    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'ZendXml\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zendxml/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite138ae397c557b28c9a5a96e37a6e241::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite138ae397c557b28c9a5a96e37a6e241::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite138ae397c557b28c9a5a96e37a6e241::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}