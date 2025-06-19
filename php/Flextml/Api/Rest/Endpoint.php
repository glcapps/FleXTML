<?php

namespace Flextml\Api\Rest;

use Flextml\Api\Rest\RequestMapper;
use Flextml\Api\Rest\ResponseFormatter;
use Flextml\Core\Element;

class Endpoint
{
    public static function handle(): void
    {
        header('Content-Type: application/json');

        try {
            $element = RequestMapper::fromGlobals();
            $output = ResponseFormatter::toJson($element);

            echo json_encode(['status' => 'ok', 'data' => $output], JSON_PRETTY_PRINT);
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}