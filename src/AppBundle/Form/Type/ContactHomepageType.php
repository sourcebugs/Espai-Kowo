<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use EWZ\Bundle\RecaptchaBundle\Form\Type\RecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

/**
 * Class ContactHomepageType
 *
 * @category FormType
 * @package  AppBundle\Form\Type
 * @author   Wilson Iglesias <wiglesias83@gmail.com>
 */
class ContactHomepageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label'    => false,
                    'required' => true,
                    'attr'     => array(
                        'placeholder' => 'frontend.forms.name',
                    ),
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label'       => false,
                    'required'    => true,
                    'attr'        => array(
                        'placeholder' => 'frontend.forms.email',
                    ),
                )
            )
            ->add(
                'phone',
                TextType::class,
                array(
                    'label'    => false,
                    'required' => false,
                    'attr'     => array(
                        'placeholder' => 'frontend.forms.phone',
                    ),
                )
            )
            ->add(
                'recaptcha',
                RecaptchaType::class,
                array(
                    'label'       => false,
                    'mapped'      => false,
                    'constraints' => array(
                        new RecaptchaTrue(),
                    ),
                    'attr' => array(
                        'options' => array(
                            'theme' => 'light',
                            'type'  => 'image',
                            'size'  => 'normal',
                            'defer' => true,
                            'async' => false,
                        ),
                    ),
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'frontend.forms.send',
                    'attr'  => array(
                        'class' => 'btn-kowo',
                    ),
                )
            );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'contact_homepage';
    }
}
