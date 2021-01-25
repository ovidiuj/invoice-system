<?php


namespace App\Controller;


use App\Response\ApiResponseInterface;
use App\Services\RecipientServiceInterface;
use App\TransferObjects\Request\RecipientRequestTransfer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RecipientController extends BaseController
{
    private RecipientServiceInterface $recipientService;

    public function __construct(
        ApiResponseInterface $apiResponse,
        recipientServiceInterface $recipientService
    )
    {
        parent::__construct($apiResponse);
        $this->recipientService = $recipientService;
    }


    /**
     * @Route("/recipient/create", name="recipient_create", methods={"POST"})
     */
    public function create(RecipientRequestTransfer $recipientRequestTransfer)
    {
        try {
            $mandant = $this->recipientService->createRecipient($recipientRequestTransfer);

            return $this->apiResponse->buildJsonResponse($mandant, 'recipient');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }
}