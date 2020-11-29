<?php
require("vendor/autoload.php");
$openapi = \OpenApi\scan('../api');
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();