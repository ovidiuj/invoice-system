<?php


namespace App\Services\Email;


use App\Entity\Invoice;
use App\TransferObjects\Response\InvoiceResponseTransfer;

class EmailService implements EmailServiceInterface
{
    public function sendEmail(Invoice $invoice): InvoiceResponseTransfer
    {
        // TODO: Implement sendEmail() method.
    }
}