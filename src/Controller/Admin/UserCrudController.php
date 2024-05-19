<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_ADMIN')
            ->setPageTitle('index', 'Utilisateurs :')
            ->setPageTitle('new', 'Créer un utilisateur')
            ->setPageTitle('edit', fn (User $user) => (string) $user->getFullname())
            ->setPageTitle('detail', fn (User $user) => (string) $user->getFullName())
            ->setDefaultSort(['lastname' => 'ASC'])
            ->setPaginatorPageSize(10)
            ->setEntityLabelInSingular('un Utilisateur');
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];

        // Vérifie le contexte et l'instance de l'utilisateur
        $user = $this->getContext()->getEntity()->getInstance();

        $fields = [
            IdField::new('id')->onlyOnIndex(),
            FormField::addFieldset('Détails de l\'utilisateur'),
            TextField::new('firstname', 'Prénom :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Prénom de l\'utilisateur']])
                ->setColumns(6),
            TextField::new('lastname', 'Nom :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Nom de l\'utilisateur']])
                ->setColumns(6),
            EmailField::new('email', 'Email :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Email de l\'utilisateur']]),
            TextField::new('address', 'Adresse :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Adresse de l\'utilisateur']])
                ->setColumns(6)
                ->hideOnIndex(),
            TextField::new('postalCode', 'Code postal :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Code postal de l\'utilisateur']])
                ->setColumns(6)
                ->hideOnIndex(),
            TextField::new('city', 'Ville :')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Ville de l\'utilisateur']])
                ->setColumns(6)
                ->hideOnIndex(),
            TelephoneField::new('phone', 'Téléphone')
                ->setFormTypeOptions(['attr' => ['placeholder' => 'Téléphone de l\'utilisateur']])
                ->setColumns(6),
        ];

        $fields[] = TextField::new('plainPassword', 'Mot de passe :')
            ->onlyWhenCreating()->setRequired(true)
            ->setFormTypeOptions(['attr' => ['placeholder' => 'Mot de passe de l\'utilisateur']])
            ->hideOnIndex();
        $fields[] = FormField::addPanel('Changer le mot de passe')->setIcon('fas fa-key')->onlyWhenUpdating();
        $fields[] = TextField::new('plainPassword', 'Nouveau mot de passe :')
            ->onlyWhenUpdating()->setRequired(false)
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Nouveau mot de passe de l\'utilisateur'],
            ])
            ->setHelp('Pour modifier le mot de passe, vous devez saisir un nouveau mot de passe. Sinon, laissez le champ vide.')
            ->hideOnIndex();

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setFirstname(ucfirst($entityInstance->getFirstname()))
            ->setLastname(strtoupper($entityInstance->getLastname()));
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setFirstname(ucfirst($entityInstance->getFirstname()))
            ->setLastname(strtoupper($entityInstance->getLastname()));
        parent::updateEntity($entityManager, $entityInstance);
    }
}




