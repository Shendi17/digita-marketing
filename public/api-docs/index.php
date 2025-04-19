<?php
require '../../vendor/autoload.php';

use OpenApi\Annotations as OA;

$openapi = \OpenApi\Generator::scan([__DIR__ . '/../api']);
header('Content-Type: application/json');
echo $openapi->toJson();
