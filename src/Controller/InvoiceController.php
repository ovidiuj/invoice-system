<?php


namespace App\Controller;

use App\Response\ApiResponseInterface;
use App\Services\InvoiceServiceInterface;
use App\TransferObjects\Request\InvoiceRequestTransfer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends BaseController
{
    protected InvoiceServiceInterface $invoiceService;

    public function __construct(
        ApiResponseInterface $apiResponse,
        InvoiceServiceInterface $invoiceService
    )
    {
        parent::__construct($apiResponse);
        $this->invoiceService = $invoiceService;
    }

     /**
      * @Route("/invoice/create", name="invoice_create", methods={"POST"})
      */
    public function create(InvoiceRequestTransfer $invoiceRequestTransfer)
    {
        try {
            $invoice = $this->invoiceService->createInvoice($invoiceRequestTransfer);

            return $this->apiResponse->buildJsonResponse($invoice, 'invoice');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }

    /**
     * @Route("/invoice/send/{id}", name="invoice_send", methods={"POST"})
     */
    public function sendInvoiceToTheCustomer(Request $request)
    {
        try {
            $invoice = $this->invoiceService->sendInvoiceToTheCustomer($request->get('id'));

            return $this->apiResponse->buildJsonResponse($invoice, 'invoice');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }

    /**
     * @Route("/invoice/pay/{id}", name="invoice_pay", methods={"POST"})
     */
    public function markInvoiceAsPaid(Request $request)
    {
        try {
            $invoice = $this->invoiceService->markInvoiceAsPaid($request->get('id'));

            return $this->apiResponse->buildJsonResponse($invoice, 'invoice');
        } catch (ConflictHttpException $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        } catch (\Exception | \Throwable $exception) {
            $this->apiResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->apiResponse->buildErrorResponse($exception->getMessage());
        }
    }



}