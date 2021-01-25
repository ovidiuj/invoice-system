<?php

namespace App\Response\Rest;

use Symfony\Component\HttpFoundation\Request;

interface RestResponseInterface
{
    public const RESPONSE_ERRORS = 'errors';
    public const RESPONSE_DATA   = 'data';

    public function addError(string $error);

    public function getErrors(): array;

    public function addResource(RestResourceInterface $restResource): RestResponseInterface;

    public function getResources(): array;
}
