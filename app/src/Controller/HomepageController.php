<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('homepage/index.html.twig');
    }
}