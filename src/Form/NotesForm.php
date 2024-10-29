<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;

class NotesForm extends AbstractType {

    function buildForm(FormFormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder' => 'Entrez votre nom']])
            ->add('matieres', TextType::class, ['label' => 'Matières'])
            ->add('note', TextType::class, ['label' => 'Note'])
            ->add('envoyer', SubmitType::class);

        
    }
}
