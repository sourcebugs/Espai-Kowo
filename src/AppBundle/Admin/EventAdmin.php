<?php

namespace AppBundle\Admin;

use AppBundle\Repository\EventCategoryRepository;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class EventAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class EventAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Activity';
    protected $baseRoutePattern = 'activitats/activitat';
    protected $datagridValues = array(
        '_sort_by'    => 'date',
        '_sort_order' => 'desc',
    );

    /**
     * Configure route collection
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.event.event', $this->getFormMdSuccessBoxArray(8))
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.event.event',
                )
            )
            ->add(
                'shortDescription',
                null,
                array(
                    'label' => 'backend.admin.event.shortdescription',
                )
            )
            ->add(
                'description',
                'ckeditor',
                    array(
                        'label'       => 'backend.admin.event.description',
                        'config_name' => 'my_config',
                        'required'    => true,
                )
            )
            ->add(
                'imageFile',
                'file',
                array(
                    'label'    => 'backend.admin.event.image',
                    'help'     => $this->getImageHelperFormMapperWithThumbnail(),
                    'required' => false,
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'categories',
                null,
                array(
                    'label' => 'backend.admin.event.category',
                    'query_builder' => function (EventCategoryRepository $repository) {
                        return $repository->getAllSortedByTitleQB();
                    },
                )
            )
            ->add(
                'date',
                'sonata_type_date_picker',
                array(
                    'label'    => 'backend.admin.event.date',
                    'format'   => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'enabled',
                'checkbox',
                array(
                    'label'    => 'backend.admin.enabled',
                    'required' => false,
                )
            )
            ->end();
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'date',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.event.date',
                    'field_type' => 'sonata_type_date_picker',
                    'format'     => 'd-m-Y',
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.event.event',
                )
            )
            ->add(
                'categories',
                null,
                array(
                    'label' => 'backend.admin.event.category',
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'backend.admin.event.description',
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'backend.admin.enabled',
                    'editable' => true,
                )
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'image',
                null,
                array(
                    'label'    => 'backend.admin.event.image',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig'
                )
            )
            ->add(
                'date',
                'date',
                array(
                    'label'    => 'backend.admin.event.date',
                    'format'   => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.event.event',
                    'editable' => true,
                )
            )
            ->add(
                'categories',
                null,
                array(
                    'label'    => 'backend.admin.event.category',
                    'editable' => true,
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'backend.admin.enabled',
                    'editable' => true,
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label'   => 'backend.admin.actions',
                    'actions' => array(
                        'show'   => array('template' => '::Admin/Buttons/list__action_show_button.html.twig'),
                        'edit'   => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    )
                )
            );
    }
}
