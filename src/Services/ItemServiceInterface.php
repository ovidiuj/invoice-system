<?php


namespace App\Services;


use App\Entity\Item;
use App\TransferObjects\Request\ItemRequestTransfer;
use App\TransferObjects\Response\ItemResponseTransfer;

interface ItemServiceInterface
{
    public function createItem(ItemRequestTransfer $itemRequestTransfer): ItemResponseTransfer;
}