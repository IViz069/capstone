<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita7f1457a38448cbb82af530022fe0dc3
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Docxmerge\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Docxmerge\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita7f1457a38448cbb82af530022fe0dc3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita7f1457a38448cbb82af530022fe0dc3::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}