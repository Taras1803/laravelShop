<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MaterialRequest as StoreRequest;
use App\Http\Requests\MaterialRequest as UpdateRequest;

/**
 * Class MaterialCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MaterialCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Material');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/material');
        $this->crud->setEntityNameStrings('material', 'materials');

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
                'name' => 'name',
            ],
            [
                'label' => 'Status',
                'type' => 'enum',
                'name' => 'status',
            ],
        ]);

        $this->crud->addFields([
            [
                'label' => "Image",
                'name' => "image",
                'type' => 'image',
                'upload' => true,
                'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
                'crop' => false, // set to true to allow cropping, false to disable
            ],
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'name',

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
        ],'update/create/both');

        // add asterisk for fields that are required in MaterialRequest
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
}
