<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CatalogCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CatalogCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Admin\CatalogCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/catalog/categories');
        CRUD::setEntityNameStrings('категорию', 'Категории');

        $this->crud->enableReorder('title', 3);

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

        $this->crud->orderBy('lft');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CatalogCategoryRequest::class);

//        CRUD::setFromDb(); // fields


        CRUD::addField([
            'name'  => 'title',
            'type'  => 'text',
            'label' => 'Заголовок',
            'tab'   => 'Описание'
        ]);

        CRUD::addField([
            'name'  => 'description',
            'type'  => 'ckeditor',
            'label' => 'Описание',
            'tab'   => 'Описание'
        ]);

        CRUD::addField([
            'name'  => 'status',
            'type'  => 'enum',
            'label' => 'Статус',
            'tab'   => 'Описание'
        ]);

        CRUD::addField([
            'name'  => 'slug',
            'type'  => 'text',
            'label' => 'Ярлык (URL)',
            'hint' =>  'ярлык будет автоматический сгенерирован из заголовка, если оставить пустым.',
            'tab'   => 'SEO'
        ]);

        CRUD::addField([
            'name'  => 'meta_title',
            'type'  => 'text',
            'label' => 'Meta title',
            'tab'   => 'SEO'
        ]);

        CRUD::addField([
            'name'  => 'meta_description',
            'type'  => 'text',
            'label' => 'Meta description',
            'tab'   => 'SEO'
        ]);

        CRUD::addField([
            'name'  => 'meta_keywords',
            'type'  => 'text',
            'label' => 'Meta keywords',
            'tab'   => 'SEO'
        ]);

        CRUD::addField([
            'label'     => 'Родитель', // Table column heading
            'type'      => 'select2_nested',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'name'      => 'parent_id', // the method that defines the relationship in your Model
//            'pivot'     => true,
            'entity'    => 'parent', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Admin\CatalogCategory', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'tab'       => 'Связи',
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
