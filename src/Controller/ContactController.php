<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_list')]
    public function list(): Response
    {
        $number = random_int(0, 100);

        return $this->render(
            'contact/index.html.twig',
            [
                'number' => $number,
            ],
        );
    }
}
