<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit690814a7d69d338f745c30849929d4d2
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HamyarSaz\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HamyarSaz\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit690814a7d69d338f745c30849929d4d2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit690814a7d69d338f745c30849929d4d2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit690814a7d69d338f745c30849929d4d2::$classMap;

        }, null, ClassLoader::class);
    }
}