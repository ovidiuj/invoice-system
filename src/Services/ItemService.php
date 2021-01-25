<?php


namespace App\Services;


use App\Entity\Item;
use App\TransferObjects\Request\ItemRequestTransfer;
use App\TransferObjects\Response\ItemResponseTransfer;

class ItemService extends AbstractService implements ItemServiceInterface
{

    public function createItem(ItemRequestTransfer $itemRequestTransfer): ItemResponseTransfer
    {
        $item = new Item();
        $item->setName($itemRequestTransfer->getName());

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        $itemResponseTransfer = new ItemResponseTransfer();

        return $itemResponseTransfer->setName($item->getName());
    }
}