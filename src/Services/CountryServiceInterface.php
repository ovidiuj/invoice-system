<?php


namespace App\Services;


use App\TransferObjects\Request\CountryRequestTransfer;
use App\TransferObjects\Response\CountryResponseTransfer;

interface CountryServiceInterface
{
    public function createCountry(CountryRequestTransfer $countryRequestTransfer): CountryResponseTransfer;
}