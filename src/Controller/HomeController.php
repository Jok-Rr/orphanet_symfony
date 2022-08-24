<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function index(ManagerRegistry $doctrine): Response
  {
    $news = $doctrine->getRepository(News::class)->findBy(['international' => 0], ['id' => 'DESC'], 5);
    $events = $doctrine->getRepository(Event::class)->findBy([], ['id' => 'DESC'], 3);
    $news_international = $doctrine->getRepository(News::class)->findBy(['international' => 1], ['id' => 'DESC'], 3);
    
    return $this->render('home/index.html.twig', ['events' => $events, 'news' => $news, 'news_international' => $news_international]);
  }

  public function navigation(ManagerRegistry $doctrine): Response
  {
    $page = $doctrine->getRepository(Page::class)->findBy(['in_navigation' => 1]);
    return $this->render('_navigation.html.twig', [
      'navigation' => $page
    ]);
  }
}
