<?php

namespace App\Response\Rest;

use App\TransferObjects\ResponseTransferInterface;

interface RestResourceBuilderInterface
{

    public function createRestResource(
        string $type,
        ?string $id = null,
        ?ResponseTransferInterface $attributeTransfer = null
    ): RestResourceInterface;


    public function createRestResponse(): RestResponseInterface;
}
