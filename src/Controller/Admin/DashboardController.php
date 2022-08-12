<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
  public function __construct(private AdminUrlGenerator $adminUrlGenerator)
  {
  }

  #[Route('/admin', name: 'admin')]
  public function index(): Response
  {
    $url = $this->adminUrlGenerator->setController(EventCrudController::class)->generateUrl();
    return $this->redirect($url);
  }

  public function configureDashboard(): Dashboard
  {
    return Dashboard::new()
      ->setTitle('Orphanet');
  }

  public function configureMenuItems(): iterable
  {
    yield MenuItem::section('Tableau de Bord', 'fa fa-home');
    yield MenuItem::section('Evenements', 'fa fa-home');

    yield MenuItem::subMenu('Actions', 'fa fa-bars')->setSubItems([
      MenuItem::linkToCrud('Créer un évenement', 'fa fa-plus', Event::class)->setAction(Crud::PAGE_NEW),
      MenuItem::linkToCrud('Voir les évenements', 'fa fa-eye', Event::class)
    ]);

    yield MenuItem::section('Pages', 'fa fa-page');


    yield MenuItem::subMenu('Actions', 'fa fa-bars')->setSubItems([
      MenuItem::linkToCrud('Créer une pages', 'fa fa-plus', Page::class)->setAction(Crud::PAGE_NEW),
      MenuItem::linkToCrud('Voir les pages', 'fa fa-eye', Page::class)
    ]);
  }
}
