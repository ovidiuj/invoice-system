<?php


namespace App\Controller;


use App\Response\ApiResponseInterface;
use App\Services\ItemServiceInterface;
use App\TransferObjects\Request\InvoiceRequestTransfer;
use App\TransferObjects\Request\ItemRequestTransfer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ItemController extends BaseController
{
    private ItemServiceInterface $itemService;

    public function __construct(
        ApiResponseInterface $apiResponse,
        ItemServiceInterface $itemService
    )
    {
        parent::__construct($apiResponse);
        $this->itemService = $itemService;
    }
    /**
     * @Route("/item/create", name="item_create", methods={"POST"})
     */
    public function create(ItemRequestTransfer $itemRequestTransfer)
    {
        try {
            $mandant = $this->itemService->createItem($itemRequestTransfer);

            return $this->apiResponse->buildJsonResponse($mandant, 'item');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }
}