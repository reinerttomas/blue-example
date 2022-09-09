<?php
declare(strict_types=1);

namespace App\Controller\Traits;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @mixin AbstractController
 */
trait FlashTrait
{
    private function addFlashSuccess(string $message): void
    {
        $this->addFlash('success', $message);
    }

    private function addFlashWarning(string $message): void
    {
        $this->addFlash('warning', $message);
    }

    private function addFlashDanger(string $message): void
    {
        $this->addFlash('danger', $message);
    }
}
