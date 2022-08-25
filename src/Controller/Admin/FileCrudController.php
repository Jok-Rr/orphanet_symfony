<?php

namespace App\Controller\Admin;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FileCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return File::class;
  }

  public function configureActions(Actions $actions): Actions
  {
    return $actions
      ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
        return $action->setIcon('fa-solid fa-pen-to-square')->setLabel('Modifier');
      })
      ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
        return $action->setIcon('fa-solid fa-trash-can')->setLabel('Supprimer');
      })
      ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
        return $action->setIcon('fa-solid fa-plus')->setLabel('Ajouter un document');
      })
      ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
        return $action->setIcon('fa-solid fa-plus')->setLabel('Ajouter le document');
      })
      ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);
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
      ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
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
      ImageField::new('upload', 'Document')
        ->setBasePath('/uploads/files')
        ->setUploadDir('public/upload/files')
        ->hideOnIndex(),
      TextField::new('extension', 'Extension du document')
        ->hideOnForm()
        ->onlyOnIndex(),
      NumberField::new('file_size', 'Taille du document')
        ->hideOnForm()
        ->onlyOnIndex()
        ->setNumDecimals(3)
        ->formatValue(function ($value) {
          return "$value Mo";
        }),
      TextField::new('external_url', '[Option] Lien externe si le document est externe au site')
        ->hideOnIndex(),
      DateTimeField::new('created_at', 'Créer le')
        ->hideOnForm(),
      DateTimeField::new('updated_at', 'Modifié le')
        ->hideOnForm(),
    ];
  }

  public function convert_bytes($val, $type_val, $type_wanted)
  {
    $tab_val = array("o", "ko", "Mo", "Go", "To", "Po", "Eo");
    if (!(in_array($type_val, $tab_val) && in_array($type_wanted, $tab_val)))
      return 0;
    $tab = array_flip($tab_val);
    $diff = $tab[$type_val] - $tab[$type_wanted];
    if ($diff > 0)
      return ($val * pow(1024, $diff));
    if ($diff < 0)
      return ($val / pow(1024, -$diff));
    return ($val);
  }

  public function persistEntity(EntityManagerInterface $em, $entityInstance): void
  {
    if (!$entityInstance instanceof File) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    $entityInstance->setUpdatedAt(new \DateTimeImmutable());
    $entityInstance->setFileSize($this->convert_bytes(filesize($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload()), 'o', 'Mo'));
    $entityInstance->setExtension(strtoupper(pathinfo($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload(), PATHINFO_EXTENSION)));

    parent::persistEntity($em, $entityInstance);
  }
  public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
  {
    if (!$entityInstance instanceof File) return;
    $entityInstance->setUpdatedAt(new \DateTimeImmutable());

    $entityInstance->setFileSize($this->convert_bytes(filesize($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload()), 'o', 'Mo'));

    $entityInstance->setExtension(strtoupper(pathinfo($this->getParameter('kernel.project_dir') . '/public/upload/files/' . $entityInstance->getUpload(), PATHINFO_EXTENSION)));

    parent::persistEntity($entityManager, $entityInstance);
  }
}
