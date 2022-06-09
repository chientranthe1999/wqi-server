<?php


namespace App\Constants;


class ApiCodes
{
    public const UNCAUGHT_EXCEPTION = 200;
    public const HTTP_NOT_FOUND = 201;
    public const HTTP_SERVICE_UNAVAILABLE = 202;
    public const HTTP_EXCEPTION = 203;
    public const UNAUTHORIZED_EXCEPTION = 204;
    public const UNAUTHENTICATED_EXCEPTION = 206;
    public const FORBIDDEN_EXCEPTION = 207;
    public const VALIDATION_EXCEPTION = 422;
    public const BAD_REQUEST = 400;
    public const UNAUTHENTICATED = 401;
    public const SERVER_ERROR = 500;

    public const ACCOUNT_INCORRECT = 'ACCOUNT_INCORRECT';
    public const TOKEN_EXPIRED = 'TOKEN_EXPIRED';
    public const TOKEN_NOT_FOUND = 'TOKEN_NOT_FOUND';
    public const NOT_AUTHENTICATION = 'NOT_AUTHENTICATION';

    private const READABLE_CODE_MAP = [
        'default' => 'UnknownException',
        self::UNCAUGHT_EXCEPTION => 'UncaughtException',
        self::HTTP_NOT_FOUND => 'NotFoundException',
        self::HTTP_SERVICE_UNAVAILABLE => 'ServiceUnavailable',
        self::HTTP_EXCEPTION => 'HttpException',
        self::UNAUTHORIZED_EXCEPTION => 'UnauthorizedException',
        self::UNAUTHENTICATED_EXCEPTION => 'UnauthenticatedException',
        self::VALIDATION_EXCEPTION => 'InvalidParametersException',
        self::FORBIDDEN_EXCEPTION => 'ForbiddenException',
        self::BAD_REQUEST => 'BadRequest',
        self::UNAUTHENTICATED => 'Unauthenticated',
        self::SERVER_ERROR => 'ServerError'
    ];

    public static function convertToReadable(int $code): string
    {
        return array_key_exists($code, self::READABLE_CODE_MAP) ? self::READABLE_CODE_MAP[$code] : self::READABLE_CODE_MAP['default'];
    }
}
