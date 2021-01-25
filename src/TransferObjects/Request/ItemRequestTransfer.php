<?php


namespace App\TransferObjects\Request;
use App\TransferObjects\RequestTransferInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ItemRequestTransfer implements RequestTransferInterface
{
    /**
     * @Assert\Sequentially({
     * @Assert\NotBlank(),
     * @Assert\NotNull(),
     * @Assert\Type(type="string")
     * })
     */
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

}