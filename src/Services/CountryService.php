<?php


namespace App\Services;


use App\Entity\Country;
use App\TransferObjects\Request\CountryRequestTransfer;
use App\TransferObjects\Response\CountryResponseTransfer;

class CountryService extends AbstractService implements CountryServiceInterface
{

    public function createCountry(CountryRequestTransfer $countryRequestTransfer): CountryResponseTransfer
    {
        $country = new Country();
        $country->setName($countryRequestTransfer->getName());
        $country->setVatValue($countryRequestTransfer->getVatValue());

        $this->entityManager->persist($country);
        $this->entityManager->flush();

        $countryResponseTransfer = new CountryResponseTransfer();
        $countryResponseTransfer->setName($country->getName());
        $countryResponseTransfer->setVatValue($country->getVatValue());

        return $countryResponseTransfer;
    }
}