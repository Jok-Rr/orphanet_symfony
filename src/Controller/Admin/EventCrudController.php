<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class EventCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Event::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      IdField::new('id')->hideOnForm(),
      TextField::new('title'),
      TextEditorField::new('content'),
      DateTimeField::new('created_at')->hideOnForm(),
      DateTimeField::new('updated_at')->hideOnForm()
    ];
  }

  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof Event) return;
    $entityInstance->setCreateAt(new \DateTimeImmutable);
    $entityInstance->setUpdatedAt(new \DateTime('now'));
    $entityInstance->setAuthor('Tom');
    parent::persistEntity($em, $entityInstance);
  }
}
