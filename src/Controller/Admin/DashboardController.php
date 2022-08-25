<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\File;
use App\Entity\News;
use App\Entity\Page;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\FileRepository;
use App\Repository\NewsRepository;
use App\Repository\PageRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
  public function __construct(private AdminUrlGenerator $adminUrlGenerator, private EventRepository $events, private NewsRepository $news, private UserRepository $users, private PageRepository $pages, private FileRepository $file)
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
      ->setTitle('DASHBOARD')
      ->setFaviconPath('images/favicon.png');
  }

  
  public function configureMenuItems(): iterable
  {
    $numEvents = $this->events->countEvent();
    $numNews = $this->news->countNews();
    $numUsers = $this->users->countUser();
    $numPages = $this->pages->countPage();
    $numFiles = $this->file->countFile();
    return [
      MenuItem::linkToUrl('Aller sur Orphanet', 'fa-solid fa-arrow-left', '/'),
      MenuItem::section('Pages', 'fa-solid fa-file-lines')->setBadge($numPages, 'secondary'),
      MenuItem::linkToCrud('Voir les pages', 'fa fa-eye', Page::class),
      MenuItem::linkToCrud('Ajouter une page', 'fa fa-plus', Page::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Actualités', 'fa-solid fa-calendar')->setBadge($numNews, 'secondary'),
      MenuItem::linkToCrud('Voir les actualités', 'fa fa-eye', News::class),
      MenuItem::linkToCrud('Ajouter une actualité ', 'fa fa-plus', News::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Evénements', 'fa-solid fa-newspaper')->setBadge($numEvents, 'secondary'),
      MenuItem::linkToCrud('Voir les évenements', 'fa fa-eye', Event::class),
      MenuItem::linkToCrud('Ajouter un évenement', 'fa fa-plus', Event::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Documents', 'fa-solid fa-file')->setBadge($numFiles, 'secondary'),
      MenuItem::linkToCrud('Voir les documents', 'fa fa-eye', File::class)->setAction(Crud::PAGE_INDEX),
      MenuItem::linkToCrud('Ajouter un document', 'fa fa-plus', File::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section('Utilisateurs', 'fa-solid fa-users')->setBadge($numUsers, 'secondary'),
      MenuItem::linkToCrud('Voir les utilisateurs', 'fa fa-eye', User::class),
      MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),

      MenuItem::section(),
      MenuItem::linkToLogout('Logout', 'fa-solid fa-right-from-bracket')
    ];
  }
}
