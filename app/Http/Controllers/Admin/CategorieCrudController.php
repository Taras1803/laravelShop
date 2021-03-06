<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categorie;
use App\Models\CategoriesDescription;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CategorieRequest as StoreRequest;
use App\Http\Requests\CategorieRequest as UpdateRequest;
use Illuminate\Support\Facades\Session;

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
                'label' => 'Image',
                'type' => 'image',
                'name' => 'image',
            ],
            [
                'label' => 'Name',
                'type' => 'text',
                'name' => 'title'
            ],
            [
                'name' => 'status',
                'type' => 'enum',
                'label' => 'Category status'
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
                'name' => 'title',
            ],
            [
                'label' => 'Description',
                'type' => 'wysiwyg',
                'name' => 'description',
                'entity'    => 'getCategoryDescription',
                'attribute' => 'description',
                'model'     => 'App\Models\CategoriesDescription',
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
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $products = Categorie::find($id)->products;
        if(count($products) > 0){
            return  redirect()->back();
        }else{
            CategoriesDescription::where(['parent_id' => $id])->delete();
            return $this->crud->delete($id);
        }
    }
}
