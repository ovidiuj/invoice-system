<?php
namespace App\TransferObjects\Request;

use App\TransferObjects\RequestTransferInterface;
use Symfony\Component\Validator\Constraints as Assert;

class InvoiceRequestTransfer implements RequestTransferInterface
{
    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="string")
     * })
     */
    private $recipientId;

    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="float")
     * })
     */
    private $netAmount;

    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type("array")
     * })
     */
    private $items;

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    public function setRecipientId(string $recipientId): InvoiceRequestTransfer
    {
        $this->recipientId = $recipientId;

        return $this;
    }

    public function getNetAmount(): float
    {
        return $this->netAmount;
    }

    public function setNetAmount(float $netAmount): InvoiceRequestTransfer
    {
        $this->netAmount = $netAmount;

        return $this;
    }

    public function getGrossAmount(): float
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(float $grossAmount): InvoiceRequestTransfer
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): InvoiceRequestTransfer
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): InvoiceRequestTransfer
    {
        $this->items = $items;

        return $this;
    }

}