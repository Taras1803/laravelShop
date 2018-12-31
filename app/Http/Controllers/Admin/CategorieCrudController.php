<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CategorieRequest as StoreRequest;
use App\Http\Requests\CategorieRequest as UpdateRequest;

/**
 * Class CategorieCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategorieCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Categorie');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/categorie');
        $this->crud->setEntityNameStrings('categorie', 'categories');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->setColumns([
            [
                'label' => 'Name',
                'type' => 'select',
                'name' => 'name',
                'entity'    => 'categoryDescription',
                'attribute' => 'name',
                'model'     => 'App\Models\CategoriesDescription',

            ],
            [
                'name' => 'status',
                'type' => 'text',
                'label' => 'Status'
            ],
        ]);
        $this->crud->addFields([
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'name',
                'entity'    => 'categoryDescription',
                'attribute' => 'name',
                'model'     => 'App\Models\CategoriesDescription',

            ],
            [
                'label' => 'Description',
                'type' => 'wysiwyg',
                'name' => 'description',
                'entity'    => 'categoryDescription',
                'attribute' => 'description',
                'model'     => 'App\Models\CategoriesDescription',
            ],
            [
                'type' => 'hidden',
                'name' => 'parent_id',
                'entity'    => 'categoryDescription',
                'attribute' => 'parent_id',
                'model'     => 'App\Models\CategoriesDescription',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'enum',
            ],
        ],'update/create/both');
        // add asterisk for fields that are required in CategorieRequest
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
