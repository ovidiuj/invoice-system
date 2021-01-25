<?php


namespace App\TransferObjects\Response;


use App\TransferObjects\ResponseTransferInterface;

class ItemResponseTransfer implements ResponseTransferInterface
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ItemResponseTransfer
    {
        $this->name = $name;

        return $this;
    }


}