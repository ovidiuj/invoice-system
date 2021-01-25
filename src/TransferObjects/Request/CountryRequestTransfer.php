<?php


namespace App\TransferObjects\Request;


use App\TransferObjects\RequestTransferInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CountryRequestTransfer implements RequestTransferInterface
{
    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="string")
     * })
     */
    private $name;

    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="integer")
     * })
     */
    private $vatValue;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): CountryRequestTransfer
    {
        $this->name = $name;

        return $this;
    }

    public function getVatValue(): int
    {
        return $this->vatValue;
    }

    public function setVatValue(int $vatValue): CountryRequestTransfer
    {
        $this->vatValue = $vatValue;

        return $this;
    }
}