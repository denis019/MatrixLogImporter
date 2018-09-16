<?php
require __DIR__.'/vendor/autoload.php';

use App\Application\CLI\ImportLogsCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ImportLogsCommand());
$application->run();