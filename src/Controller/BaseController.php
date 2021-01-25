<?php


namespace App\Controller;


use App\Response\ApiResponseInterface;
use App\Services\InvoiceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected ApiResponseInterface $apiResponse;

    public function __construct(
        ApiResponseInterface $apiResponse
    )
    {
        $this->apiResponse = $apiResponse;
    }
}