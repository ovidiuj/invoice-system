<?php


namespace App\Controller;


use App\Response\ApiResponseInterface;
use App\Services\CountryServiceInterface;
use App\TransferObjects\Request\CountryRequestTransfer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CountryController extends BaseController
{
    private CountryServiceInterface $countryService;

    public function __construct(
        ApiResponseInterface $apiResponse,
        CountryServiceInterface $countryService
    )
    {
        parent::__construct($apiResponse);
        $this->countryService = $countryService;
    }
    /**
     * @Route("/country/create", name="country_create", methods={"POST"})
     */
    public function create(CountryRequestTransfer $countryRequestTransfer)
    {
        try {
            $mandant = $this->countryService->createCountry($countryRequestTransfer);

            return $this->apiResponse->buildJsonResponse($mandant, 'country');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }
}