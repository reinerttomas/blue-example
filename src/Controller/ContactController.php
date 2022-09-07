<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private ContactService $contactService
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

    #[Route('/{username}', name: 'app_contact_edit')]
    public function edit(string $username): Response
    {
        try {
            $contact = $this->contactService->getByUsername($username);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        // @todo - formular

        return $this->redirectToRoute(
            'app_contact_edit',
            [
                'username' => $contact->getUsername(),
            ]
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
