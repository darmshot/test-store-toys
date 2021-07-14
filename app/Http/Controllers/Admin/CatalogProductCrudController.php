<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CatalogProductRequest;
use App\Models\Admin\CatalogAttribute;
use App\Models\Admin\CatalogProduct;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Admin\CatalogProduct::class);
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
//        CRUD::column('thumb')->type('image');

        // image
        CRUD::addColumn([
            'label' => "Изображение",
            'name' => "thumb",
            'type' => 'image',
            'visibleInTable' => true,
            'visibleInModal' => false,
//'fake' =>true
            'entity'         => false, // the method that defines the relationship in your Model

//            'crop' => true, // set to true to allow cropping, false to disable
//            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        CRUD::addColumn([
            'name'           => 'title',
            'type'           => 'text',
            'label'          => 'Заголовок',
            'visibleInTable' => true,
            'visibleInModal' => true,
        ]);

        CRUD::addColumn([
            'name'           => 'description',
            'type'           => 'text',
            'label'          => 'Описание',
            'visibleInTable' => true,
            'visibleInModal' => true,
        ]);

        CRUD::addColumn([
            'name'           => 'price',
            'type'           => 'number',
            'label'          => 'Цена',
            'visibleInTable' => true,
            'visibleInModal' => true,
        ]);
        CRUD::addColumn([
            // 1-n relationship
            'label'          => 'Категория', // Table column heading
            'type'           => 'select',
//            'name'           => 'fake_main_category', // the column that contains the ID of that connected entity;
            'entity'         => 'categories', // the method that defines the relationship in your Model
            'attribute'      => 'title', // foreign key attribute that is shown to user
            'visibleInTable' => true,
            'visibleInModal' => false,
        ]);
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

        CRUD::addField([
            'name'  => 'title',
            'type'  => 'text',
            'label' => 'Заголовок',
            'tab'   => 'Описание'
        ]);

//        CRUD::addField([
//            'name'  => 'json_attributes',
//            'type'  => 'text',
////            'fake' => true,
////            'store_in' => 'json_attributes',
//            'label' => 'JsonAttributes',
//            'tab'   => 'Описание'
//        ]);


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
            'name'  => 'sku',
            'type'  => 'text',
            'label' => 'Sku',
            'tab'   => 'Данные'
        ]);

        CRUD::addField([
            'name'  => 'price',
            'type'  => 'text',
            'label' => 'Цена',
            'tab'   => 'Данные'
        ]);

        CRUD::addField([
            'name'  => 'price_special',
            'type'  => 'text',
            'label' => 'Скидка',
            'tab'   => 'Данные'
        ]);

        CRUD::addField([
            'name'  => 'slug',
            'type'  => 'text',
            'label' => 'Ярлык (URL)',
            'hint'  => 'ярлык будет автоматический сгенерирован из заголовка, если оставить пустым.',
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
            'name'      => 'fake_categories', // the method that defines the relationship in your Model
//            'pivot'     => true,
//            'fake' => true,
//            'entity'    => 'categories', // the method that defines the relationship in your Model
//            'entity'    =>     'getCategories', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Admin\CatalogCategory', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('lft', 'ASC')->get()->map(function ($row) {
                    $row->title = (($row->depth > 1) ? str_repeat('-', $row->depth - 1) : '') . ' ' . $row->title;

                    return $row;
                });
            }),
            'tab'       => 'Связи',
        ]);

        CRUD::addField([
            'label'     => 'Главная категория', // Table column heading
            'type'      => 'select2',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'name'      => 'fake_main_category', // the method that defines the relationship in your Model
//            'pivot'     => true,
//            'entity'    => 'getCategories', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Admin\CatalogCategory', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('lft', 'ASC')->get()->map(function ($row) {
                    $row->title = (($row->depth > 1) ? str_repeat('-', $row->depth - 1) : '') . ' ' . $row->title;

                    return $row;
                });
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
            'model'     => 'App\Models\Admin\CatalogManufacturer', // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'tab'       => 'Связи',
        ]);

        CRUD::addField([   // n-n relationship
            'label'                => "Похожие товары",
            // Table column heading
            'type'                 => "relationship",
            'name'                 => 'relatedProducts',
            // a unique identifier (usually the method that defines the relationship in your Model)
            'entity'               => 'relatedProducts',
            // the method that defines the relationship in your Model
            'attribute'            => "title",
            // foreign key attribute that is shown to user
            'data_source'          => url("admin/api/catalog/products"),
            // url to controller search function (with /{id} should return model)
            'pivot'                => true,
            // on create&update, do you need to add/delete pivot table entries?

            // OPTIONAL
            'delay'                => 500,
            // the minimum amount of time between ajax requests when searching in the field
            'model'                => "App\Models\CatalogProduct",
            // foreign key model
            'placeholder'          => "Выберите товары",
            // placeholder for the select
            'minimum_input_length' => 1,
            // minimum characters to type before querying results
            // 'include_all_form_fields'  => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            'tab'                  => 'Связи',

        ]);

        CRUD::addField([   // CustomHTML
            'name'  => 'attributes_separator',
            'type'  => 'custom_html',
            'value' => '<br><h2>Аттрибуты</h2><hr class="mb-n3">',
            'tab'   => 'Связи'
        ]);

        CRUD::addField([   // repeatable
            'name'           => 'fake_product_attributes',
            'label'          => '',
            'type'           => 'repeatable',
            'fields'         => [
                [
                    'name'                    => 'id',
                    'type'                    => 'select2_from_ajax',
                    'label'                   => 'Атрибут',
//                    'entity'               => 'json_attributes',
                    'attribute'               => "title",
                    'data_source'             => url("admin/api/catalog/products/attributes"),
                    'placeholder'             => "Выберетие атрибут", // placeholder for the select
                    'minimum_input_length'    => 1, // minimum characters to type before querying results
                    'model'                   => "App\Models\Admin\CatalogAttribute", // foreign key model
                    'method'                  => 'POST', // optional - HTTP method to use for the AJAX call (GET, POST)
                    'wrapper'                 => ['class' => 'form-group col-md-6'],
                    'include_all_form_fields' => true
                ],
                [
                    'name'    => 'value',
                    'type'    => 'text',
                    'label'   => 'Значение',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ]
            ],

            // optional
            'new_item_label' => 'Add Attribute', // customize the text of the button
            'init_rows'      => 0, // number of empty rows to be initialized, by default 1
            'min_rows'       => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
            'max_rows'       => 20, // maximum rows allowed, when reached the "new item" button will be hidden
            'tab'            => 'Связи',
        ]);

        CRUD::addField([   // Browse multiple
            'name'       => 'images',
            'label'      => 'Изображения',
            'type'       => 'browse_multiple',
            // 'multiple'   => true, // enable/disable the multiple selection functionality
            'sortable'   => true, // enable/disable the reordering with drag&drop
            'mime_types' => ['image'], // visible mime prefixes; ex. ['image'] or ['application/pdf']
            'tab'        => 'Данные',

        ]);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         *
         *   CRUD::addField([   // CustomHTML
         * 'name' => 'metas_separator',
         * 'type' => 'custom_html',
         * 'value' => '<br><h2>'.trans('backpack::pagemanager.metas').'</h2><hr>',
         * ]);
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
