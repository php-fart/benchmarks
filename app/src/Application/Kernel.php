<?php

declare(strict_types=1);

namespace App\Application;

use Spiral\Boot\Bootloader\CoreBootloader;
use Spiral\Bootloader as Framework;
use Spiral\DotEnv\Bootloader\DotenvBootloader;
use Spiral\Monolog\Bootloader\MonologBootloader;
use Spiral\Prototype\Bootloader\PrototypeBootloader;
use Spiral\Scaffolder\Bootloader\ScaffolderBootloader;
use Spiral\Tokenizer\Bootloader\TokenizerListenerBootloader;

class Kernel extends \Spiral\Framework\Kernel
{
    protected const SYSTEM = [
        CoreBootloader::class,
        TokenizerListenerBootloader::class,
        DotenvBootloader::class,
    ];

    protected const LOAD = [
        // Logging and exceptions handling
        MonologBootloader::class,
        Bootloader\ExceptionHandlerBootloader::class,

        // Application specific logs
        Bootloader\LoggingBootloader::class,

        // Core Services
        Framework\SnapshotsBootloader::class,

        // Security and validation
        Framework\Security\EncrypterBootloader::class,

        // Console commands
        Framework\CommandBootloader::class,
        ScaffolderBootloader::class,

        // Fast code prototyping
        PrototypeBootloader::class,
    ];

    protected const APP = [];
}
