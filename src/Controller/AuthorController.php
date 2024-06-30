<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\BookRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author/{name}', name: 'app_author')]
    public function index(
        #[MapEntity(mapping: ['name' => 'name'])]
        Author $author
    ): Response
    {
        return $this->render('author/index.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/author/from-repo/{name}', name: 'app_author_from_repo')]
    public function fromRepo(
        #[MapEntity(mapping: ['name' => 'name'])]
        Author $author,
        BookRepository $bookRepository,
    ): Response
    {
        return $this->render('author/from-repo.html.twig', [
            'author' => $author,
            'bestSellers' => $bookRepository->findBestSellers($author->getName()),
        ]);
    }
}
