namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class InscriptionForm extends AbstractType
{

    function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');
        $builder->setAttributes(['class' => "MonID"]);
        $builder
            ->add(
                'email',
                EmailType::class,
                ['attr' => ['placeholder' => "Entrez votre email"], "constraints" => [
                    new Assert\Email(['message' => 'Email invalide!'])
                ]]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    "label" => "Nom de famille",
                    "required" => false,
                    'attr' => ['placeholder' => "Entrez votre nom"],
                    "constraints" => [
                        new Assert\NotBlank(["message" => 'Nom obligatoire']),
                        new Assert\Length(
                            <!-- ajout de la contrainte de longueur -->
                            [
                                "min" => 2,
                                "max" => 255,
                                'minMessage' => "Le nom est trop court",
                                "maxMessage" => "Le nom est trop long"
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'attr' => ['placeholder' => "Entrez votre prénom"],
                    "constraints" => [
                        new Assert\NotBlank(["message" => 'Nom obligatoire']),
                        new Assert\Length(
                            [
                                "min" => 2,
                                "max" => 255,
                                'minMessage' => "Le nom est trop court",
                                "maxMessage" => "Le nom est trop long"
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'genre',
                ChoiceType::class,
                <!-- choiceType permet de créer une liste de choix(options) dans le formulaire -->
                ['choices' => ['Masculin' => "m", 'Feminin' => "f"]]
            )
            ->add("Envoyer", SubmitType::class, ["attr" => ['class' => "button"]]);

        $builder->get('nom')->setRequired(false);
        $builder->get('prenom')->setRequired(false);
    }
}