<?php
declare(strict_types=1);

namespace App\Service;

use App\Business\ContactBusiness;
use App\Entity\Contact;
use App\Exception\NotFoundException;
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

    public function create(
        string $name,
        string $surname,
        string $email,
        string $username,
        ?string $phone,
        ?string $note,
    ): Contact {
        return $this->contactBusiness->create(
            $name,
            $surname,
            $email,
            $username,
            $phone,
            $note,
        );
    }

    public function update(
        Contact $contact,
        string $name,
        string $surname,
        string $email,
        ?string $phone,
        ?string $note,
    ): Contact {
        return $this->contactBusiness->update(
            $contact,
            $name,
            $surname,
            $email,
            $phone,
            $note,
        );
    }

    public function remove(Contact $contact): void
    {
        $this->contactBusiness->remove($contact);
    }
}
