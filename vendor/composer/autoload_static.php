<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1829b9032e84e3a599bfdc66ff208260
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tina\\PesepayDonation\\' => 21,
        ),
        'C' => 
        array (
            'Codevirtus\\Payments\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tina\\PesepayDonation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Codevirtus\\Payments\\' => 
        array (
            0 => __DIR__ . '/..' . '/codevirtus/pesepay/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1829b9032e84e3a599bfdc66ff208260::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1829b9032e84e3a599bfdc66ff208260::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1829b9032e84e3a599bfdc66ff208260::$classMap;

        }, null, ClassLoader::class);
    }
}
