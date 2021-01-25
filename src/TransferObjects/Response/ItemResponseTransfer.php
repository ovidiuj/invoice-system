<?php


namespace App\TransferObjects\Response;


use App\TransferObjects\ResponseTransferInterface;

class ItemResponseTransfer implements ResponseTransferInterface
{
    private $id;
    private string $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


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