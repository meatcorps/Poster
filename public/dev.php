<?php

require_once __DIR__ . '/../vendor/autoload.php';

$debugmode = true;

$app = require_once __DIR__ . '/../app/app.php';

$app->run();