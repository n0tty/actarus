<?php

namespace RequeteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

use ArusProjectBundle\Repository\ArusProjectRepository;


class ImportType extends AbstractType
{
	public function __construct( $options=null ) {
		$this->options = $options;
	}

	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'project', 'entity', array(
				'empty_data'  => null,
				'empty_value' => '- - -',
				'constraints' => [new NotBlank()],
				'property' => 'name',
				'class' => 'ArusProjectBundle\\Entity\\ArusProject',
				'query_builder' => function(ArusProjectRepository $er){
					return $er->createQueryBuilder('p')->orderBy('p.name', 'ASC');
				})
			)
            ->add( 'format', ChoiceType::class, ['choices'=>$this->options['t_format'],'data'=>'bs_xml64','constraints'=>[new NotBlank()]] )
            ->add( 'source_file', FileType::class, ['required'=>false] )
		;
    }
}
