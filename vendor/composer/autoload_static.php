<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8cbc20c4b33aef0ceda9da6bcd8d7652
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8cbc20c4b33aef0ceda9da6bcd8d7652::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8cbc20c4b33aef0ceda9da6bcd8d7652::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
