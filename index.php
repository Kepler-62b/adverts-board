<?php
// внешний index для компонентов приложения

declare(strict_types=1);

namespace App;

use Dev\Tests\Services\TestServices;
use Framework\Services\Database\DatabaseConfigs;

require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');
// chdir('/app/public');
