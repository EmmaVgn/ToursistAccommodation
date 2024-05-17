<?php

namespace App\Controller\Admin;


use App\Entity\Add;
use App\Form\AddImageFormType;
use Symfony\Component\Intl\Countries;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AddCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Add::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Annonces :')
            ->setPageTitle('new', 'Créer une annonce')
            ->setPaginatorPageSize(10)
            ->setEntityLabelInSingular('une Annonce');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            FormField::addColumn(6),
            TextField::new('title', 'Nom de l\'annonce'),
            MoneyField::new('price', 'Prix de la nuitée')
                ->setCurrency('EUR')
                ->setTextAlign('left')
                ->setFormTypeOption('divisor', 100),
            NumberField::new('capacity', 'Capacité du logement')->setNumDecimals(0),
            NumberField::new('rooms', 'Nombre de chambre')->setNumDecimals(0),
            NumberField::new('beds', 'Nombre de lits')->setNumDecimals(0),
            TextField::new('slug', 'Slug de l\'annonce'),
            CollectionField::new('images')
                ->setEntryType(AddImageFormType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
            FormField::addColumn(6),
            TextEditorField::new('introduction', 'Description courte')->hideOnIndex(),
            TextEditorField::new('description', 'Contenu de l\'annonce')->hideOnIndex(),
        ];
    }



    
}