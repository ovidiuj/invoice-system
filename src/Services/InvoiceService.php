<?php
namespace App\Services;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use App\Repository\ItemRepository;
use App\Repository\RecipientRepository;
use App\Services\Email\EmailServiceInterface;
use App\Services\Mapper\InvoiceMapperInterface;
use App\TransferObjects\Request\InvoiceRequestTransfer;
use App\TransferObjects\Response\InvoiceResponseTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Workflow\Registry;

class InvoiceService implements InvoiceServiceInterface
{
    private EntityManagerInterface $entityManager;
    private InvoiceRepository $invoiceRepository;
    private RecipientRepository $recipientRepository;
    private InvoiceMapperInterface $invoiceMapper;
    private ItemRepository $itemRepository;
    private Registry $workflowRegistry;
    private EmailServiceInterface $emailService;

    public function __construct(
        EntityManagerInterface $entityManager,
        InvoiceRepository $invoiceRepository,
        RecipientRepository $recipientRepository,
        InvoiceMapperInterface $invoiceMapper,
        ItemRepository $itemRepository,
        Registry $workflowRegistry,
        EmailServiceInterface $emailService
    )
    {
        $this->entityManager = $entityManager;
        $this->invoiceRepository = $invoiceRepository;
        $this->recipientRepository = $recipientRepository;
        $this->invoiceMapper = $invoiceMapper;
        $this->itemRepository = $itemRepository;
        $this->workflowRegistry = $workflowRegistry;
        $this->emailService = $emailService;
    }

    public function createInvoice(InvoiceRequestTransfer $invoiceRequestTransfer): InvoiceResponseTransfer
    {
        $recipientEntity = $this->recipientRepository->findOneById($invoiceRequestTransfer->getRecipientId());
        if ($recipientEntity === null) {
            throw new ConflictHttpException('A recipient with provided id does not exist.');
        }

        $items = $invoiceRequestTransfer->getItems();
        if(count($items) == 0) {
            throw new ConflictHttpException('The items are missing');
        }

        $itemEntities = $this->itemRepository->getItemsByIds($items);
        if(count($itemEntities) == 0) {
            throw new ConflictHttpException('Not found items');
        }

        $invoice = $this->invoiceMapper->mapInvoiceEntityFromInvoiceRequestTransfer(
            new Invoice(),
            $recipientEntity,
            $invoiceRequestTransfer,
            $itemEntities
        );

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        return $this->invoiceMapper->mapInvoiceEntityToInvoiceResponseTransfer($invoice);
    }

    public function sendInvoiceToTheCustomer(int $invoiceId): InvoiceResponseTransfer
    {
        $invoiceEntity = $this->invoiceRepository->findOneById($invoiceId);
        if ($invoiceEntity === null) {
            throw new ConflictHttpException('An invoice with provided id does not exist.');
        }

        $this->emailService->sendEmail($invoiceEntity);
        $invoiceWorkFlow = $this->workflowRegistry->get($invoiceEntity);
        $invoiceWorkFlow->apply($invoiceEntity, 'send');

        return $this->invoiceMapper->mapInvoiceEntityToInvoiceResponseTransfer($invoiceEntity);
    }

    public function markInvoiceAsPaid(int $invoiceId): InvoiceResponseTransfer
    {
        $invoiceEntity = $this->invoiceRepository->findOneById($invoiceId);
        if ($invoiceEntity === null) {
            throw new ConflictHttpException('An invoice with provided id does not exist.');
        }

        $invoiceWorkFlow = $this->workflowRegistry->get($invoiceEntity);
        $invoiceWorkFlow->apply($invoiceEntity, 'pay');

        return $this->invoiceMapper->mapInvoiceEntityToInvoiceResponseTransfer($invoiceEntity);
    }
}