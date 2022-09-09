<?php
declare(strict_types=1);

namespace App\Service;

use App\Business\ContactBusiness;
use App\Entity\Contact;
use App\Exception\NotFoundException;
use App\Exception\UniqueException;
use App\Form\Dto\ContactDto;
use App\Repository\ContactRepository;
use Doctrine\ORM\NonUniqueResultException;

class ContactService
{
    public function __construct(
        private ContactRepository $contactRepository,
        private ContactBusiness $contactBusiness,
    ) {
    }

    /**
     * @return array<Contact>
     */
    public function list(int $limit, int $offset): array
    {
        return $this->contactRepository->list($limit, $offset);
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Contact
    {
        return $this->contactRepository->get($id);
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function getByUsername(string $username): Contact
    {
        return $this->contactRepository->getByUsername($username);
    }

    /**
     * @throws UniqueException
     */
    public function create(ContactDto $contactDto): Contact
    {
        return $this->contactBusiness->create(
            $contactDto->name,
            $contactDto->surname,
            $contactDto->email,
            $contactDto->username,
            $contactDto->phone,
            $contactDto->note,
        );
    }

    /**
     * @throws UniqueException
     */
    public function update(Contact $contact, ContactDto $contactDto): Contact
    {
        return $this->contactBusiness->update(
            $contact,
            $contactDto->name,
            $contactDto->surname,
            $contactDto->email,
            $contactDto->phone,
            $contactDto->note,
        );
    }

    public function remove(Contact $contact): void
    {
        $this->contactBusiness->remove($contact);
    }
}
