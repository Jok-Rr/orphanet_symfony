<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
  #[Route('/page/{slug}', name: 'single_page')]
  public function singlePage(ManagerRegistry $doctrine, $slug): Response
  {

    $page = $doctrine->getRepository(Page::class)->findOneBy(['slug' => $slug]);

    return $this->render('page/single.html.twig', [
      'data' => $page,
    ]);
  }
}
