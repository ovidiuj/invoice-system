<?php


namespace App\TransferObjects\Response;


use App\TransferObjects\ResponseTransferInterface;

class InvoiceResponseTransfer implements ResponseTransferInterface
{
    private string $id;
    private string $recipientId;
    private array $items;
    private float $netAmount;
    private float $grossAmount;
    private float $vatAmount;
    private string $state;
    private string $createdAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    public function setRecipientId(string $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getNetAmount(): float
    {
        return $this->netAmount;
    }

    public function setNetAmount(float $netAmount): void
    {
        $this->netAmount = $netAmount;
    }

    public function getGrossAmount(): float
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(float $grossAmount): void
    {
        $this->grossAmount = $grossAmount;
    }

    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): void
    {
        $this->vatAmount = $vatAmount;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}