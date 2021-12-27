<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e607a420da4e53bd28e11996603cc03
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Elias\\Wpvfr\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Elias\\Wpvfr\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e607a420da4e53bd28e11996603cc03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e607a420da4e53bd28e11996603cc03::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9e607a420da4e53bd28e11996603cc03::$classMap;

        }, null, ClassLoader::class);
    }
}