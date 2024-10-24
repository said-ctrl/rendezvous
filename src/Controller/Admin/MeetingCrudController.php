<?php

namespace App\Controller\Admin;

use App\Entity\Meeting;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MeetingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meeting::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            DateField::new('date'),
            TextEditorField::new('description'),
        ];
    }
    
}
