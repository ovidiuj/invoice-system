<?php

namespace App\Response\Rest;

use Symfony\Component\HttpFoundation\Request;

class RestResponse implements RestResponseInterface
{

    protected array $resources = [];

    protected array $errors = [];

    protected string $basePath;


    public function addError(string $error): RestResponseInterface
    {
        $this->errors[RestResponseInterface::RESPONSE_ERRORS][] = $error;

        return $this;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }


    public function addResource(RestResourceInterface $restResource): RestResponseInterface
    {
        $resource = $restResource->toArray();
        if (isset($resource[RestResourceInterface::RESOURCE_ATTRIBUTES]['uuid'])) {
            unset($resource[RestResourceInterface::RESOURCE_ATTRIBUTES]['uuid']);
        }
        $this->resources[RestResponseInterface::RESPONSE_DATA][] = $resource;

        return $this;
    }


    public function getResources(): array
    {
        return $this->resources;
    }

    private function setBasePath(Request $request): void
    {
        $urlParams = parse_url($request->getUri());
        $this->basePath = $urlParams['path'];
    }
}
