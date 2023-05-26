<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit177ef356e2a3c3dd28776e07dfbd6ce2
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Src\\' => 4,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Src\\' => 
        array (
            0 => '/',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit177ef356e2a3c3dd28776e07dfbd6ce2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit177ef356e2a3c3dd28776e07dfbd6ce2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit177ef356e2a3c3dd28776e07dfbd6ce2::$classMap;

        }, null, ClassLoader::class);
    }
}