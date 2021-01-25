<?php


namespace App\Services;


use App\Entity\Invoice;
use App\Entity\Recipient;
use App\Repository\CountryRepository;
use App\Services\Mapper\RecipientMapperInterface;
use App\TransferObjects\Request\RecipientRequestTransfer;
use App\TransferObjects\Response\RecipientResponseTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RecipientService extends AbstractService implements RecipientServiceInterface
{
    private CountryRepository $countryRepository;
    private RecipientMapperInterface $recipientMapper;

    public function __construct(
        EntityManagerInterface $entityManager,
        CountryRepository $countryRepository,
        RecipientMapperInterface $recipientMapper
    )
    {
        parent::__construct($entityManager);
        $this->countryRepository = $countryRepository;
        $this->recipientMapper = $recipientMapper;
    }

    public function createRecipient(RecipientRequestTransfer $recipientRequestTransfer): RecipientResponseTransfer
    {
        $countryEntity = $this->countryRepository->findOneById($recipientRequestTransfer->getCountryId());
        if ($countryEntity === null) {
            throw new ConflictHttpException('A country with provided id does not exist.');
        }

        $recipient = new Recipient();
        $recipient->setCountry($countryEntity);
        $recipient = $this->recipientMapper->mapRecipientEntityFromRecipientRequestTransfer(
            $recipient,
            $recipientRequestTransfer
        );

        $this->entityManager->persist($recipient);
        $this->entityManager->flush();

        return $this->recipientMapper->mapRecipientEntityToRewcipientResponseTransfer($recipient);
    }
}