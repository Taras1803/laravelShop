<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductsAttributesValue;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Products_attributeRequest as StoreRequest;
use App\Http\Requests\Products_attributeRequest as UpdateRequest;

/**
 * Class Products_attributeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Products_attributeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Products_attribute');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/products_attribute');
        $this->crud->setEntityNameStrings('products_attribute', 'products_attributes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->setColumns([
            [
                'label' => 'Id',
                'type' => 'text',
                'name' => 'id',
            ],
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'name',
            ],
        ]);
        $this->crud->addFields([
            [
                'label' => "Name",
                'name' => "name",
                'type' => 'text',
            ],
            [
                'label' => "Slug",
                'name' => "slug",
                'type' => 'text',
            ]
        ]);

        $this->crud->addField([
                // Custom Field
                'label' => 'Значение аттрибута',
                'type' => 'attribute',
                'name' => 'attribute',

        ]);

        // add asterisk for fields that are required in Products_attributeRequest
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
        unset($request['value']);
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $this->crud->setOperation('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        ProductsAttributesValue::where(['product_attributes_id' => $id])->delete();
        return $this->crud->delete($id);
    }

}
