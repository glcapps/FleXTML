#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Flextml\Core\Element;
use Flextml\Transform\JsonToXml;
use Flextml\Transform\XmlToJson;
use Flextml\Schema\Validator;

function printUsage()
{
    echo "FleXTML CLI\n";
    echo "Usage:\n";
    echo "  flextml.php json2xml [file]\n";
    echo "  flextml.php xml2json [file]\n";
    echo "  flextml.php validate [file]\n";
    exit(1);
}

if ($argc < 3) {
    printUsage();
}

$command = $argv[1];
$file = $argv[2];

if (!file_exists($file)) {
    echo "File not found: $file\n";
    exit(1);
}

$content = file_get_contents($file);

switch ($command) {
    case 'json2xml':
        $json = json_decode($content, true);
        if (!$json) {
            echo "Invalid JSON.\n";
            exit(1);
        }
        echo JsonToXml::convert($json, true) . "\n";
        break;

    case 'xml2json':
        $result = XmlToJson::convert($content);
        if (!$result) {
            echo "Invalid XML.\n";
            exit(1);
        }
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        break;

    case 'validate':
        $json = json_decode($content, true);
        if (!$json) {
            echo "Invalid JSON.\n";
            exit(1);
        }
        $errors = [];
        if (Validator::validate($json, $errors)) {
            echo "✔ Valid FleXTML structure.\n";
        } else {
            echo "❌ Validation errors:\n";
            foreach ($errors as $err) {
                echo "- $err\n";
            }
        }
        break;

    default:
        printUsage();
}
