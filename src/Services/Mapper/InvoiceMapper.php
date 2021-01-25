<?php


namespace App\Services\Mapper;


use App\Entity\Invoice;
use App\Entity\Item;
use App\Entity\Recipient;
use App\TransferObjects\Request\InvoiceRequestTransfer;
use App\TransferObjects\Response\InvoiceResponseTransfer;

class InvoiceMapper implements InvoiceMapperInterface
{
    public function mapInvoiceEntityFromInvoiceRequestTransfer(
        Invoice $invoice,
        Recipient $recipient,
        InvoiceRequestTransfer $invoiceRequestTransfer,
        array $itemEntities
    ): Invoice
    {
        $invoice->addRecipient($recipient);
        $invoice->setNetAmount($invoiceRequestTransfer->getNetAmount());
        $invoice->setVatAmount($this->getVatValue($invoiceRequestTransfer, $recipient));
        $invoice->setGrossAmount($this->getGrossAmount($invoiceRequestTransfer, $recipient));

        foreach ($itemEntities as $itemEntity) {
            if($itemEntity instanceof Item) {
                $invoice->addItem($itemEntity);
            }
        }

        return $invoice;
    }

    public function mapInvoiceEntityToInvoiceResponseTransfer(Invoice $invoice): InvoiceResponseTransfer
    {
        $invoiceResponseTransfer = new InvoiceResponseTransfer();
        $invoiceResponseTransfer->setId($invoice->getId());
        $invoiceResponseTransfer->setRecipientId($invoice->getRecipient()->getId());
        $invoiceResponseTransfer->setNetAmount($invoice->getNetAmount());
        $invoiceResponseTransfer->setVatAmount($invoice->getVatAmount());
        $invoiceResponseTransfer->setGrossAmount($invoice->getGrossAmount());
        $invoiceResponseTransfer->setState($invoice->getState());

        $items = [];
        foreach ($invoice->getItems() as $key => $item) {
            $items[$key]['id'] = $item->getId();
            $items[$key]['name'] = $item->getName();
        }
        $invoiceResponseTransfer->setItems($items);
        $invoiceResponseTransfer->setCreatedAt($invoice->getCreatedAt()->format('Y-m-d h:i:s'));

        return $invoiceResponseTransfer;
    }


    private function getVatValue(InvoiceRequestTransfer $invoiceRequestTransfer, Recipient $recipient): float
    {
        return round($invoiceRequestTransfer->getNetAmount() * ($recipient->getCountry()->getVatValue() / 100), 2);
    }

    private function getGrossAmount(InvoiceRequestTransfer $invoiceRequestTransfer, Recipient $recipient): float
    {
        return $invoiceRequestTransfer->getNetAmount() + $this->getVatValue($invoiceRequestTransfer, $recipient);
    }
}