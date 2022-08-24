<?php

namespace App\Controller\Admin;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FileCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return File::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      // Les labels utilisés pour faire référence à l'entité dans les titres, les boutons, etc.
      ->setEntityLabelInSingular('document')
      ->setEntityLabelInPlural('documents')

      // Le titre visible en haut de la page et le contenu de l'élément <title>
      // Cela peut inclure ces différents placeholders : %entity_id%, %entity_label_singular%, %entity_label_plural%
      ->setPageTitle('index', 'Liste des %entity_label_plural%')
      ->setPageTitle('new', 'Créer une %entity_label_singular%')
      ->setPageTitle('edit', 'Modifier le %entity_label_singular% <small>(#%entity_id%)</small>')

      // Définit le tri initial appliqué à la liste
      // (l'utilisateur peut ensuite modifier ce tri en cliquant sur les colonnes de la table)
      ->setDefaultSort(['id' => 'ASC']);
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      IdField::new('id')->hideOnForm()->hideOnIndex(),
      TextField::new('name', 'Nom du document'),
      ImageField::new('upload', 'Image du bandeau')
        ->setBasePath('/uploads/files')
        ->setUploadDir('public/upload/files')
        ->hideOnIndex(),
      TextField::new('external_url', '[Option] Lien externe si le document est externe au site')
        ->hideOnIndex(),
      DateTimeField::new('created_at', 'Créer le')
        ->hideOnForm(),
      DateTimeField::new('updated_at', 'Modifié le')
        ->hideOnForm(),
    ];
  }


  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof File) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    $entityInstance->setFileSize(filesize($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload()));
    $entityInstance->setExtension(pathinfo($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload(), PATHINFO_EXTENSION));

    parent::persistEntity($em, $entityInstance);
  }
  public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
  {
    if (!$entityInstance instanceof File) return;

    $entityInstance->setUpdatedAt(new \DateTimeImmutable());
    $entityInstance->setFileSize(filesize($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload()));
    $entityInstance->setExtension(pathinfo($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload(), PATHINFO_EXTENSION));
    parent::persistEntity($entityManager, $entityInstance);
  }
}
