<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      // Les labels utilisés pour faire référence à l'entité dans les titres, les boutons, etc.
      ->setEntityLabelInSingular('page')
      ->setEntityLabelInPlural('pages')
      // Le titre visible en haut de la page et le contenu de l'élément <title>
      // Cela peut inclure ces différents placeholders : %entity_id%, %entity_label_singular%, %entity_label_plural%
      ->setPageTitle('index', 'Liste des %entity_label_plural%')
      ->setPageTitle('new', 'Créer une %entity_label_singular%')
      ->setPageTitle('edit', 'Modifier la %entity_label_singular% <small>(#%entity_id%)</small>')

      // Définit le tri initial appliqué à la liste
      // (l'utilisateur peut ensuite modifier ce tri en cliquant sur les colonnes de la table)
      ->setDefaultSort(['id' => 'ASC']);
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
      BooleanField::new('in_navigation')->renderAsSwitch(true),
      ImageField::new('hero_pic')
        ->setBasePath('/uploads/pages')
        ->setUploadDir('public/upload/pages')
        ->hideOnIndex(),
      TextEditorField::new('header')->hideOnIndex(),
      TextEditorField::new('content')->hideOnIndex(),
      DateTimeField::new('created_at')->hideOnForm(),
      DateTimeField::new('updated_at')->hideOnForm()
    ];
  }

  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof Page) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    $entityInstance->setUpdatedAt(new \DateTimeImmutable());
    parent::persistEntity($em, $entityInstance);
  }
  public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
  {
    if (!$entityInstance instanceof Page) return;

    $entityInstance->setUpdatedAt(new \DateTimeImmutable());

    parent::persistEntity($entityManager, $entityInstance);
  }
}
