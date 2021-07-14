<?php

namespace App\Traits\Admin;

trait PageTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Page Templates for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - page name (only seen by admins)
    | - page title
    | - page slug
    */

    private function services()
    {
        $this->crud->addField([   // CustomHTML
            'name'  => 'metas_separator',
            'type'  => 'custom_html',
            'value' => '<br><h2>' . trans('backpack::pagemanager.metas') . '</h2><hr>',
        ]);
        $this->crud->addField([
            'name'     => 'meta_title',
            'label'    => trans('backpack::pagemanager.meta_title'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([
            'name'     => 'meta_description',
            'label'    => trans('backpack::pagemanager.meta_description'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([
            'name'     => 'meta_keywords',
            'type'     => 'textarea',
            'label'    => trans('backpack::pagemanager.meta_keywords'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([   // CustomHTML
            'name'  => 'content_separator',
            'type'  => 'custom_html',
            'value' => '<br><h2>' . trans('backpack::pagemanager.content') . '</h2><hr>',
        ]);
        $this->crud->addField([
            'name'        => 'content',
            'label'       => trans('backpack::pagemanager.content'),
            'type'        => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);
    }

    private function about_us()
    {
        $this->crud->addField([
            'name'        => 'content',
            'label'       => trans('backpack::pagemanager.content'),
            'type'        => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);
    }

    private function home()
    {
        $this->crud->addField([   // CustomHTML
            'name'  => 'metas_separator',
            'type'  => 'custom_html',
            'value' => '<br><h2>' . trans('backpack::pagemanager.metas') . '</h2><hr>',
        ]);
        $this->crud->addField([
            'name'     => 'meta_title',
            'label'    => trans('backpack::pagemanager.meta_title'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([
            'name'     => 'meta_description',
            'label'    => trans('backpack::pagemanager.meta_description'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([
            'name'     => 'meta_keywords',
            'type'     => 'textarea',
            'label'    => trans('backpack::pagemanager.meta_keywords'),
            'fake'     => true,
            'store_in' => 'extras',
        ]);
        $this->crud->addField([   // CustomHTML
            'name'  => 'content_separator',
            'type'  => 'custom_html',
            'value' => '<br><h2>' . trans('backpack::pagemanager.content') . '</h2><hr>',
        ]);
        $this->crud->addField([
            'name'        => 'content',
            'label'       => trans('backpack::pagemanager.content'),
            'type'        => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);

        $this->crud->addField([
            'name'                 => 'products',
            'label'                => 'Товары',
            'type'                 => 'select2_from_ajax_multiple',
            'entity'               => false,
            'fake'                 => true,
            'attribute'            => "title",
            'data_source'          => url("admin/api/catalog/products"),
            'model'                => "App\Models\Admin\CatalogProduct",
            'placeholder'          => "Выберите товары", // placeholder for the select
            'minimum_input_length' => 1,
            'store_in'             => 'extras',
            'tab'                  => 'Связи',

        ]);
    }

    private function template_search()
    {
        $this->crud->addField([
            'name'        => 'content',
            'label'       => trans('backpack::pagemanager.content'),
            'type'        => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);
    }
}
