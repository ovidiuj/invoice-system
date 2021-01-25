<?php


namespace App\TransferObjects\Response;


use App\TransferObjects\ResponseTransferInterface;

class CountryResponseTransfer implements ResponseTransferInterface
{
    private string $name;
    private int $vatValue = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CountryResponseTransfer
    {
        $this->name = $name;

        return $this;
    }

    public function getVatValue(): int
    {
        return $this->vatValue;
    }

    public function setVatValue(int $vatValue): CountryResponseTransfer
    {
        $this->vatValue = $vatValue;

        return $this;
    }


}