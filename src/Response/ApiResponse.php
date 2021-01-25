<?php

namespace App\Response;

use App\Response\Rest\RestResourceBuilderInterface;
use App\Response\Rest\RestResourceInterface;
use App\Response\Rest\RestResponseInterface;
use App\TransferObjects\ResponseTransferInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponse implements ApiResponseInterface
{

    private array $data = [];

    private array $headers = [];

    protected int $statusCode = Response::HTTP_OK;

    private SerializerInterface $serializer;

    private RestResourceBuilderInterface $resourceBuilder;


    public function __construct(SerializerInterface $serializer, RestResourceBuilderInterface $resourceBuilder)
    {
        $this->serializer      = $serializer;
        $this->resourceBuilder = $resourceBuilder;
    }


    public function buildJsonResponse(?ResponseTransferInterface $transfer, string $type): JsonResponse
    {
        $response = $this->resourceBuilder->createRestResponse();
        $response = $this->createResponseResource($transfer, $type, $response);

        return new JsonResponse($response->getResources(), Response::HTTP_OK, $this->headers);
    }


    public function buildErrorResponse(string $error): JsonResponse
    {
        $response = $this->resourceBuilder->createRestResponse();
        $response->addError($error);
        return new JsonResponse($response->getErrors(), $this->getStatusCode());
    }


    public function getStatusCode(): int
    {
        return $this->statusCode;
    }


    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function buildJsonResponseFromSimpleArray(array $data)
    {

        $response[RestResourceInterface::RESOURCE_DATA] = $data;

        return new JsonResponse($response, Response::HTTP_OK, $this->headers);
    }

    private function createResponseResource(
        ?ResponseTransferInterface $transfer,
        string $type,
        RestResponseInterface $response
    ): RestResponseInterface {
        if ($transfer instanceof ResponseTransferInterface) {
            $restResource = $this->resourceBuilder->createRestResource(
                $type,
                $transfer->getUuid() ?? null,
                $transfer
            );

            $response->addResource($restResource);
        }

        return $response;
    }
}
