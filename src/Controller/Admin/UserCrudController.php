<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{

  public static function getEntityFqcn(): string
  {
    return User::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      // Les labels utilisés pour faire référence à l'entité dans les titres, les boutons, etc.
      ->setEntityLabelInSingular('utilisateur')
      ->setEntityLabelInPlural('utilisateurs')

      // Le titre visible en haut de la page et le contenu de l'élément <title>
      // Cela peut inclure ces différents placeholders : %entity_id%, %entity_label_singular%, %entity_label_plural%
      ->setPageTitle('index', 'Liste des %entity_label_plural%')
      ->setPageTitle('new', 'Créer un %entity_label_singular%')
      ->setPageTitle('edit', 'Modifier l\' %entity_label_singular% <small>(#%entity_id%)</small>')

      // Définit le tri initial appliqué à la liste
      // (l'utilisateur peut ensuite modifier ce tri en cliquant sur les colonnes de la table)
      ->setDefaultSort(['id' => 'ASC']);
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('email'),
      TextField::new('firstname'),
      TextField::new('lastname'),
      TextField::new('password')
        ->setFormType(PasswordType::class)
        ->hideOnIndex()
    ];
  }
}
