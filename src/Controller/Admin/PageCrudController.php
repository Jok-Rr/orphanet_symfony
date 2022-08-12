<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Page::class;
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      IdField::new('id')->hideOnForm(),
      TextField::new('title'),
      SlugField::new('slug')
        ->setTargetFieldName('title')
        ->setUnlockConfirmationMessage(
          'It is highly recommended to use the automatic slugs, but you can customize them'
        ),
      ImageField::new('hero_pic')
        ->setBasePath('/uploads/pages')
        ->setUploadDir('public/upload/pages')
        ->hideOnIndex(),
      TextEditorField::new('header')->hideOnIndex(),
      TextEditorField::new('content')->hideOnIndex(),
      BooleanField::new('in_navigation')->renderAsSwitch(false),
      DateTimeField::new('created_at')->hideOnForm(),
      DateTimeField::new('updated_at')->hideOnForm()
    ];
  }

  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof Page) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    $entityInstance->setUpdatedAt(new \DateTime('now'));
    parent::persistEntity($em, $entityInstance);
  }
  public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
  {
    if (!$entityInstance instanceof Page) return;

    $entityInstance->setUpdatedAt(new \DateTimeImmutable());

    parent::persistEntity($entityManager, $entityInstance);
  }
}
