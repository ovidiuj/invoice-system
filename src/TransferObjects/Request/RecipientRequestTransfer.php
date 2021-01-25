<?php


namespace App\TransferObjects\Request;


use App\TransferObjects\RequestTransferInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RecipientRequestTransfer implements RequestTransferInterface
{
    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * })
     */
    private $email;

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
     * @Assert\Type(type="string")
     * })
     */
    private $address;

    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="integer")
     * })
     */
    private $countryId;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): RecipientRequestTransfer
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): RecipientRequestTransfer
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): RecipientRequestTransfer
    {
        $this->address = $address;

        return $this;
    }

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): RecipientRequestTransfer
    {
        $this->countryId = $countryId;

        return $this;
    }

}