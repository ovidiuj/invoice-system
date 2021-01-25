<?php
namespace App\Services;

use App\TransferObjects\Request\InvoiceRequestTransfer;
use App\TransferObjects\Response\InvoiceResponseTransfer;

interface InvoiceServiceInterface
{
    public function createInvoice(InvoiceRequestTransfer $invoiceRequestTransfer): InvoiceResponseTransfer;

    public function sendInvoiceToTheCustomer(int $invoiceId): InvoiceResponseTransfer;

    public function markInvoiceAsPaid(int $invoiceId): InvoiceResponseTransfer;
}