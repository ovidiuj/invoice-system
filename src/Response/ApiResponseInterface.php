<?php

namespace App\Response;

use App\TransferObjects\ResponseTransferInterface;
use Symfony\Component\HttpFoundation\Request;

interface ApiResponseInterface
{
    public function buildJsonResponse(?ResponseTransferInterface $transfer, string $type);

    public function buildJsonResponseFromSimpleArray(array $data);
}
