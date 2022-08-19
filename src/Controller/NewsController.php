<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news/{slug}', name: 'single_new')]
    public function singleNews(ManagerRegistry $doctrine, $slug): Response
  {

    $page = $doctrine->getRepository(News::class)->findOneBy(['slug' => $slug]);

    return $this->render('news/single.html.twig', [
      'data' => $page,
    ]);
  }
}
