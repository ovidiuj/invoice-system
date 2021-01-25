<?php


namespace App\Services\Mapper;


use App\Entity\Recipient;
use App\TransferObjects\Request\RecipientRequestTransfer;
use App\TransferObjects\Response\RecipientResponseTransfer;

interface RecipientMapperInterface
{
    public function mapRecipientEntityFromRecipientRequestTransfer(
        Recipient $recipient,
        RecipientRequestTransfer $recipientRequestTransfer
    ): Recipient;

    public function mapRecipientEntityToRewcipientResponseTransfer(Recipient $recipient): RecipientResponseTransfer;
}