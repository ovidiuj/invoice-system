<?php


namespace App\Services\Email;


use App\Entity\Invoice;
use App\TransferObjects\Response\InvoiceResponseTransfer;

interface EmailServiceInterface
{
    public function sendEmail(Invoice $invoice): InvoiceResponseTransfer;
}