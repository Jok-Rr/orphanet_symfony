<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function index(): Response
  {

    return $this->render('home/index.html.twig', []);
  }

  public function navigation(ManagerRegistry $doctrine): Response
  {
    $page = $doctrine->getRepository(Page::class)->findBy(['in_navigation' => 1]);

    return $this->render('_navigation.html.twig', [
      'navigation' => $page
    ]);
  }
}
