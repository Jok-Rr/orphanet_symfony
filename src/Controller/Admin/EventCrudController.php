<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
      return [
        IdField::new('id')->hideOnForm()->hideOnIndex(),
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
        BooleanField::new('external_link')->renderAsSwitch(false),
        TextField::new('external_url')->hideOnIndex(),
        DateTimeField::new('created_at')->hideOnForm(),
        DateTimeField::new('updated_at')->hideOnForm()
      ];
    }
  
    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
      if (!$entityInstance instanceof Event) return;
      $entityInstance->setCreatedAt(new \DateTimeImmutable);
      parent::persistEntity($em, $entityInstance);
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
      if (!$entityInstance instanceof Event) return;
  
      $entityInstance->setUpdatedAt(new \DateTimeImmutable());
  
      parent::persistEntity($entityManager, $entityInstance);
    }
}
