<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc131508a502f30c2c477614b1105a712
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc131508a502f30c2c477614b1105a712::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc131508a502f30c2c477614b1105a712::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc131508a502f30c2c477614b1105a712::$classMap;

        }, null, ClassLoader::class);
    }
}