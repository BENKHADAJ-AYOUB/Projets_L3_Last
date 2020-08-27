<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Image;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration("Titre","Tapez un super titre pour votre annonce"))
            ->add(
            'slug',
            TextType::class, 
            $this->getConfiguration("Adresse WEB ","Tapez Tapez l'adresse web (automatique)",[
                'required'=> false
            ])
            )
            
            ->add('coverImage',UrlType::class,$this->getConfiguration("Url de l'image principale ","Donnez l'adresse d'une image qui donne vraiment envie"))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Donnez une description globale de l'annonce"))
            ->add('content',TextareaType::class ,$this->getConfiguration("Description","Tapez une déscription qui donne vraiment envie de venir chez vous !"))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true

                   
                    
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
             
        ]);
    }
}
