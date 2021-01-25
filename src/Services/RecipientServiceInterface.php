<?php


namespace App\Services;


use App\TransferObjects\Request\RecipientRequestTransfer;
use App\TransferObjects\Response\RecipientResponseTransfer;

interface RecipientServiceInterface
{
    public function createRecipient(RecipientRequestTransfer $recipientRequestTransfer): RecipientResponseTransfer;
}