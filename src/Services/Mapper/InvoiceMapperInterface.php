<?php

namespace App\Services\Mapper;

use App\Entity\Invoice;
use App\Entity\Recipient;
use App\TransferObjects\Request\InvoiceRequestTransfer;
use App\TransferObjects\Response\InvoiceResponseTransfer;

interface InvoiceMapperInterface
{
    public function mapInvoiceEntityFromInvoiceRequestTransfer(
        Invoice $invoice,
        Recipient $recipient,
        InvoiceRequestTransfer $invoiceRequestTransfer,
        array $itemEntities
    ): Invoice;

    public function mapInvoiceEntityToInvoiceResponseTransfer(Invoice $invoice): InvoiceResponseTransfer;
}