<?php
declare(strict_types=1);

namespace App\Form;

use App\Form\Dto\ContactDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var ContactDto $contactDto */
        $contactDto = $builder->getData();

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Name',
                ],
            )
            ->add(
                'surname',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Surname',
                ],
            )
            ->add(
                'username',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Username',
                    'disabled' => !$contactDto->isUsernameEmpty(),
                ],
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label' => 'Email',
                ],
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Phone',
                ],
            )
            ->add(
                'note',
                TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Note',
                    'attr' => [
                        'rows' => '5',
                    ],
                ],
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Save',
                ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDto::class,
        ]);
    }
}
