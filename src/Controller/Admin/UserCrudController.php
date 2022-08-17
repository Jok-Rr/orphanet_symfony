<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

  public static function getEntityFqcn(): string
  {
    return User::class;
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

  public function __construct(UserPasswordHasherInterface $hasher)
  {
    $this->hasher = $hasher;
  }

}
