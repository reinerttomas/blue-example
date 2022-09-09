<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\FlashTrait;
use App\Exception\NotFoundException;
use App\Exception\UniqueException;
use App\Form\ContactForm;
use App\Form\Dto\ContactDto;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    use FlashTrait;

    public function __construct(
        private ContactService $contactService,
    ) {
    }

    #[Route('/', name: 'app_contact_list')]
    public function list(): Response
    {
        $contacts = $this->contactService->list(100, 0);

        return $this->render(
            'contact/index.html.twig',
            [
                'contacts' => $contacts,
            ],
        );
    }

    #[Route('/create', name: 'app_contact_create')]
    public function create(Request $request): Response
    {
        $contactDto = new ContactDto();
        $contactForm = $this->createForm(ContactForm::class, $contactDto);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            try {
                $contact = $this->contactService->create($contactDto);

                return $this->redirectToRoute(
                    'app_contact_edit',
                    [
                        'username' => $contact->getUsername(),
                    ],
                );
            } catch (UniqueException $e) {
                $contactForm->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render(
            'contact/create.html.twig',
            [
                'contactForm' => $contactForm->createView(),
            ],
        );
    }

    #[Route('/{username}', name: 'app_contact_edit')]
    public function edit(Request $request, string $username): Response
    {
        try {
            $contact = $this->contactService->getByUsername($username);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $contactDto = ContactDto::from($contact);
        $contactForm = $this->createForm(ContactForm::class, $contactDto);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            try {
                $contact = $this->contactService->update($contact, $contactDto);

                return $this->redirectToRoute(
                    'app_contact_edit',
                    [
                        'username' => $contact->getUsername(),
                    ],
                );
            } catch (UniqueException $e) {
                $contactForm->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render(
            'contact/edit.html.twig',
            [
                'contactForm' => $contactForm->createView(),
                'contact' => $contact,
            ],
        );
    }

    #[Route('/delete/{id}', name: 'app_contact_delete')]
    public function delete(int $id): Response
    {
        try {
            $contact = $this->contactService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $this->contactService->remove($contact);

        return $this->redirectToRoute('app_contact_list');
    }
}
