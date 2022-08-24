<?php

namespace App\Controller\Admin;

use App\Entity\News;
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

class NewsCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return News::class;
  }
  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      // Les labels utilisés pour faire référence à l'entité dans les titres, les boutons, etc.
      ->setEntityLabelInSingular('actualité')
      ->setEntityLabelInPlural('actualités')

      // Le titre visible en haut de la page et le contenu de l'élément <title>
      // Cela peut inclure ces différents placeholders : %entity_id%, %entity_label_singular%, %entity_label_plural%
      ->setPageTitle('index', 'Liste des %entity_label_plural%')
      ->setPageTitle('new', 'Créer une %entity_label_singular%')
      ->setPageTitle('edit', 'Modifier l\' %entity_label_singular% <small>(#%entity_id%)</small>')

      // Définit le tri initial appliqué à la liste
      // (l'utilisateur peut ensuite modifier ce tri en cliquant sur les colonnes de la table)
      ->setDefaultSort(['id' => 'ASC']);
  }
  public function configureFields(string $pageName): iterable
  {
    return [
      IdField::new('id')->hideOnForm()->hideOnIndex(),
      TextField::new('title', 'Titre de l\'actualité'),
      SlugField::new('slug')
        ->setTargetFieldName('title')
        ->setUnlockConfirmationMessage(
          'It is highly recommended to use the automatic slugs, but you can customize them'
        ),
      TextField::new('external_url', '[Option] Lien si l\'événement est externe au site bien respecter https://')
        ->hideOnIndex(),
      BooleanField::new('international', 'Actualité internationales'),
      ImageField::new('hero_pic', 'Image du bandeau')
        ->setBasePath('/uploads/pages')
        ->setUploadDir('public/upload/pages')
        ->setUploadedFileNamePattern('[randomhash].[extension]')
        ->hideOnIndex(),
      TextEditorField::new('header', 'Chapô')
        ->hideOnIndex(),
      TextEditorField::new('content', 'Contenu')
        ->hideOnIndex(),
      DateTimeField::new('created_at', 'Créer le')
        ->hideOnForm(),
      DateTimeField::new('updated_at', 'Modifié le')
        ->hideOnForm(),
    ];
  }

  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof News) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    parent::persistEntity($em, $entityInstance);
  }
  public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
  {
    if (!$entityInstance instanceof News) return;

    $entityInstance->setUpdatedAt(new \DateTimeImmutable());

    parent::persistEntity($entityManager, $entityInstance);
  }
}
