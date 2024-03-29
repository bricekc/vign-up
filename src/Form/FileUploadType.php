<?php

// src/Form/FileUploadType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class FileUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('upload_file', FileType::class, [
                'label' => false,
                'mapped' => false, // Tell that there is no Entity to link
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [ // We want to let upload only txt, csv or Excel files
                            'text/x-comma-separated-values',
                            'text/comma-separated-values',
                            'text/x-csv',
                            'text/csv',
                            'text/plain',
                            'application/octet-stream',
                            'application/vnd.ms-excel',
                            'application/x-csv',
                            'application/csv',
                            'application/pdf',
                            'application/msword',
                            'image/jpeg',
                            'image/png',
                            'application/excel',
                            'application/vnd.msexcel',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ],
                        'mimeTypesMessage' => "This document isn't valid.",
                    ]),
                ],
            ])
            ->add('titre')
            ->add('auteur')
            ->add('description')
            ->add('video', null, ['required' => false])
            ->add('send', SubmitType::class); // We could have added it in the view, as stated in the framework recommendations
    }
}
