<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductsDescription;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->setColumns([
            [
                'label' => 'Image',
                'type' => 'image',
                'name' => 'image',
            ],
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'title',
            ],
            [
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'getCategory', // the method that defines the relationship in your Model
                'attribute' => 'title', // foreign key attribute that is shown to user
                'model' => "App\Models\Categorie" // foreign key model
            ],
            [
                'label' => "Material",
                'type' => 'select',
                'name' => 'material_id', // the db column for the foreign key
                'entity' => 'getMaterial', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Material" // foreign key model
            ],
            [
                'label' => 'Status',
                'type' => 'enum',
                'name' => 'status',
            ],
            [
                'label' => 'Price',
                'type' => 'number',
                'name' => 'price',
            ],
            [
                'label' => 'Action',
                'type' => 'number',
                'name' => 'action',
            ],
        ]);
        $this->crud->addFields([
            [
                'label' => "Product Image",
                'name' => "image",
                'type' => 'image',
                'upload' => true,
                'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
                'crop' => false, // set to true to allow cropping, false to disable
            ],
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'title',

            ],
            [
                'label' => 'Description',
                'type' => 'wysiwyg',
                'name' => 'description',
                'entity'    => 'getProductDescription',
                'model'     => 'App\Models\ProductsDescription',
            ],
            [
                'label' => "Material",
                'type' => 'select2',
                'name' => 'material_id', // the db column for the foreign key
                'entity' => 'getMaterial', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Material" // foreign key model
            ],
            [
                'label' => "Category",
                'type' => 'select2',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'getCategory', // the method that defines the relationship in your Model
                'attribute' => 'title', // foreign key attribute that is shown to user
                'model' => "App\Models\Categorie" // foreign key model
            ],
            [
                'name' => 'slug',
                'label' => 'Slug',
                'type' => 'text',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'enum',
            ],
            [
                'name' => 'price',
                'label' => 'Price',
                'type' => 'number',
                'attributes' => ['step' => 0.5],
                'prefix' => "$",
            ],
            [
                'name' => 'action',
                'label' => 'Action',
                'type' => 'number',
            ],
        ],'update/create/both');
        // add asterisk for fields that are required in ProductRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        ProductsDescription::where(['parent_id' => $id])->delete();
        return $this->crud->delete($id);
    }
}
