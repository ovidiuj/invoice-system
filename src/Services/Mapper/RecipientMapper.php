<?php


namespace App\Services\Mapper;


use App\Entity\Recipient;
use App\TransferObjects\Request\RecipientRequestTransfer;
use App\TransferObjects\Response\RecipientResponseTransfer;

class RecipientMapper implements RecipientMapperInterface
{
    public function mapRecipientEntityFromRecipientRequestTransfer(
        Recipient $recipient,
        RecipientRequestTransfer $recipientRequestTransfer
    ): Recipient
    {
        $recipient->setEmail($recipientRequestTransfer->getEmail());
        $recipient->setName($recipientRequestTransfer->getName());
        $recipient->setAddress($recipientRequestTransfer->getAddress());

        return $recipient;
    }

    public function mapRecipientEntityToRewcipientResponseTransfer(Recipient $recipient): RecipientResponseTransfer
    {
        $recipientResponseTransfer = new RecipientResponseTransfer();
        $recipientResponseTransfer->setId($recipient->getId());
        $recipientResponseTransfer->setEmail($recipient->getEmail());
        $recipientResponseTransfer->setName($recipient->getName());
        $recipientResponseTransfer->setAddress($recipient->getAddress());
        $recipientResponseTransfer->setCountryId($recipient->getCountry()->getId());

        return $recipientResponseTransfer;
    }
}