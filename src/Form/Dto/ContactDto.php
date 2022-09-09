<?php
declare(strict_types=1);

namespace App\Form\Dto;

use App\Entity\Contact;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDto
{
    #[Assert\NotBlank]
    public string $name = '';

    #[Assert\NotBlank]
    public string $surname = '';

    #[Assert\NotBlank]
    public string $username = '';

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    public string $email = '';
    public ?string $phone = null;
    public ?string $note = null;

    public static function from(Contact $contact): self
    {
        $contactDto = new self();

        $contactDto->name = $contact->getName();
        $contactDto->surname = $contact->getSurname();
        $contactDto->username = $contact->getUsername();
        $contactDto->email = $contact->getEmail();
        $contactDto->phone = $contact->getPhone();
        $contactDto->note = $contact->getNote();

        return $contactDto;
    }

    public function isUsernameEmpty(): bool
    {
        return $this->username === '';
    }
}
