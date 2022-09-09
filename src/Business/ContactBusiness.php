<?php
declare(strict_types=1);

namespace App\Business;

use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactBusiness
{
    public function __construct(
        private ContactRepository $contactRepository,
    ) {
    }

    public function create(
        string $name,
        string $surname,
        string $email,
        string $username,
        ?string $phone,
        ?string $note,
    ): Contact {
        $contact = new Contact(
            $name,
            $surname,
            $email,
            $username,
        );

        $contact->changePhone($phone)
            ->changeNote($note);

        return $this->contactRepository->store($contact);
    }

    public function update(
        Contact $contact,
        string $name,
        string $surname,
        string $email,
        ?string $phone,
        ?string $note,
    ): Contact {
        $contact->changeName($name, $surname)
            ->changeEmail($email)
            ->changePhone($phone)
            ->changeNote($note);

        return $this->contactRepository->store($contact);
    }

    public function remove(Contact $contact): void
    {
        $this->contactRepository->remove($contact);
    }
}
