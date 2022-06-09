<?php

namespace App\Http\ResponseBuilder;

use App\Constants\ApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as Builder;

class ResponseBuilder extends Builder
{
    protected function buildResponse(bool $success, int $api_code,
                                          $message_or_api_code, array $lang_args = null,
                                          $data = null, array $debug_data = null): array
    {
        // tell ResponseBuilder to do all the heavy lifting first
        $response = parent::buildResponse($success, $api_code, $message_or_api_code, $lang_args, $data, $debug_data);

        if ($response['success']) {
            return (array) $response['data'];
        }
        return [
            'code' => ApiCodes::convertToReadable($response['code']),
            'message' => $response['message'],
            'errors' => $response['data'],
            'debug' => $response['debug'] ?? null
        ];
    }
}
