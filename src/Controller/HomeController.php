<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, BookRepository $repository): Response
    {
        $viewParams = [];
        if ($request->query->has('search')) {
            $viewParams['bestSellers'] = $repository->findBestSellers($request->query->get('search'));
        }

        return $this->render('home/index.html.twig', $viewParams);
    }
}
