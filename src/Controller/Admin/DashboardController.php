<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Page;
use App\Entity\User;
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
      ->setTitle('DASHBOARD');
  }

  public function configureMenuItems(): iterable
  {
    return [
      MenuItem::section('Pages', 'fa-solid fa-file-lines'),
      MenuItem::linkToCrud('Voir les pages', 'fa fa-eye', Page::class),
      MenuItem::linkToCrud('Créer une page', 'fa fa-plus', Page::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Evènements', 'fa-solid fa-calendar'),
      MenuItem::linkToCrud('Voir les évenements', 'fa fa-eye', Event::class),
      MenuItem::linkToCrud('Créer un évenement', 'fa fa-plus', Event::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Actualités', 'fa-solid fa-newspaper'),
      MenuItem::linkToCrud('Voir les actualités', 'fa fa-eye', Event::class),
      MenuItem::linkToCrud('Créer une actualité', 'fa fa-plus', Event::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Utilisateurs', 'fa-solid fa-users'),
      MenuItem::linkToCrud('Voir les utilisateurs', 'fa fa-eye', User::class),
      MenuItem::linkToCrud('Créer un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),

    ];
  }
}
