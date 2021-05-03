<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CatalogProductRequest;
use App\Models\CatalogProduct;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CatalogProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CatalogProduct::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/catalog/products');
        CRUD::setEntityNameStrings('Товар', 'Товары');
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
        CRUD::setValidation(CatalogProductRequest::class);

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
            'label'     => 'Категории', // Table column heading
            'type'      => 'select2_multiple',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'name'      => 'categories', // the method that defines the relationship in your Model
            'fake'      => true,
            'pivot'     => true,
            'entity'    => 'categories', // the method that defines the relationship in your Model
            'model'     => 'App\Models\CatalogCategory', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'tab'       => 'Связи',
        ]);


        CRUD::addField([
            'label'     => 'Главная категория', // Table column heading
            'type'      => 'select2',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'name'      => 'main_category', // the method that defines the relationship in your Model
            'pivot'     => true,
            'entity'    => 'categories', // the method that defines the relationship in your Model
            'model'     => 'App\Models\CatalogCategory', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'tab'       => 'Связи',
        ]);


        CRUD::addField([
            'label'     => 'Производитель', // Table column heading
            'type'      => 'select2',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'name'      => 'manufacturer_id', // the method that defines the relationship in your Model
//            'pivot'     => true,
            'entity'    => 'manufacturer', // the method that defines the relationship in your Model
            'model'     => 'App\Models\CatalogManufacturer', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'tab'       => 'Связи',
        ]);


//        CRUD::addField([   // CustomHTML
//            'name' => 'metas_separator',
//            'type' => 'custom_html',
//            'value' => '<br><h2>'.trans('backpack::pagemanager.metas').'</h2><hr>',
//        ]);

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

    public function store()
    {
        // do something before validation, before save, before everything; for example:
        // $this->crud->addField(['type' => 'hidden', 'name' => 'author_id']);
//         $this->crud->removeField('attributes');


        // Note: By default Backpack ONLY saves the inputs that were added on page using Backpack fields.
        // This is done by stripping the request of all inputs that do NOT match Backpack fields for this
        // particular operation. This is an added security layer, to protect your database from malicious
        // users who could theoretically add inputs using DeveloperTools or JavaScript. If you're not properly
        // using $guarded or $fillable on your model, malicious inputs could get you into trouble.

        // However, if you know you have proper $guarded or $fillable on your model, and you want to manipulate
        // the request directly to add or remove request parameters, you can also do that.
        // We have a config value you can set, either inside your operation in `config/backpack/crud.php` if
        // you want it to apply to all CRUDs, or inside a particular CrudController:
        // $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        // The above will make Backpack store all inputs EXCEPT for the ones it uses for various features.
        // So you can manipulate the request and add any request variable you'd like.
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');

//        $this->crud->getRequest()->request->remove('attributes');
        $this->saveCategories();


        $response = $this->traitStore();

        // do something after save
//        $this->saveAttributes();


        return $response;
    }

    public function update()
    {
//        $this->saveAttributes();
        $this->saveCategories();

        $response = $this->traitUpdate();

        return $response;
    }

    public function saveAttributes()
    {
        $jsonAttributes = $this->crud->getRequest()->request->get('json_attributes');

        if ( ! empty($jsonAttributes)) {
            $attributes = collect(json_decode($jsonAttributes, true))->mapWithKeys(function ($item) {
                if (empty($item['id']) || empty($item['value'])) {
                    return [];
                }

                return [$item['id'] => ['value' => $item['value']]];
            })->filter()->all();

            CatalogProduct::find($this->crud->getRequest()->request->get('id'))->offerAttributes()->sync($attributes);
        }

        $this->crud->getRequest()->request->remove('json_attributes');
    }

    public function saveCategories()
    {
        $categories   = $this->crud->getRequest()->request->get('categories');
        $mainCategory = $this->crud->getRequest()->request->get('main_category');


        if ( ! empty($categories) || ! empty($mainCategory)) {


            $syncCategories = collect($categories)->push($mainCategory)
                                                  ->unique()
                                                  ->mapWithKeys(function ($item) use ($mainCategory) {
                                                      $isMainCategory = ($item === $mainCategory) ? true : null;

                                                      $result = [$item => ['main_category' => $isMainCategory]];

                                                      return $result;
                                                  })->all();
//
            $queryCategories = CatalogProduct::find($this->crud->getRequest()->request->get('id'))
                                           ->categories();

            $queryCategories->detach();
            $queryCategories->attach($syncCategories);



        }

        $this->crud->removeField('categories');
        $this->crud->removeField('main_category');

        $this->crud->getRequest()->request->remove('categories');
        $this->crud->getRequest()->request->remove('main_category');
    }
}
