<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
  #[Route('/event/{slug}', name: 'single_event')]
  public function singleEvent(ManagerRegistry $doctrine, $slug): Response
  {

    $page = $doctrine->getRepository(Event::class)->findOneBy(['slug' => $slug]);

    return $this->render('event/single.html.twig', [
      'data' => $page,
    ]);
  }

  #[Route('/event', name: 'all_event')]
  public function AllEvent(ManagerRegistry $doctrine): Response
  {

    $page = $doctrine->getRepository(Event::class)->findBy([], ['id' => 'DESC']);

    return $this->render('event/all.html.twig', [
      'data' => $page,
    ]);
  }
}
