<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
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
                'type' => 'images',
                'name' => 'images',
                'height' => '60px',
                'width' => '60px',

            ],
//            [
//                'label' => 'Image',
//                'type' => 'image',
//                'name' => 'image',
//                'height' => '60px',
//                'width' => '60px',
//
//            ],
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
            [ // image
                'label' => "Images",
                'name' => "images",
                'type' => 'image_multiple',
                'upload' => true,
                'crop' => false, // set to true to allow cropping, false to disable
                'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
            ],
//            [
//                'label' => "Image",
//                'name' => "image",
//                'type' => 'image',
//                'upload' => true,
//                'crop' => false, // set to true to allow cropping, false to disable
//                'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
//            ],
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
            [

                'label' => 'Attributes',
                'type' => 'product_attribute',
                'name' => 'attribute',
            ],
        ],'update/create/both');

        // add asterisk for fields that are required in ProductRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // Setup storage
        $attribute_name = "images";
        $disk = "public";
        $destination_path = "/uploads/products";
        // Then get images from request
        $input = $request->all();
        $images = $input[$attribute_name];
        $imageArray = [];
        // Now iterate images
        foreach ($images as $value) {
            // Store on disk and add to array
            if (starts_with($value, 'data:image'))
            {
                // 0. Make the image
                $image = Image::make($value);
                // 1. Generate a filename.
                $filename = md5($value.time()).'.jpg';
                // 2. Store the image on disk.
                Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                // 3. Save the path to the database
                array_push($imageArray, $destination_path.'/'.$filename);
            }
        }
        // Update $request with new array
        $request->request->set($attribute_name, $imageArray);

        // Save $request
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // Setup storage
        $attribute_name = "images";
        $disk = "public";
        $destination_path = "/uploads/products";
        // Then get images from request
        $input = $request->all();
        $images = $input[$attribute_name];
        $imageArray = [];
        // Now iterate images
        foreach ($images as $value) {
            // Store on disk and add to array
            if (starts_with($value, 'data:image'))
            {
                // 0. Make the image
                $image = Image::make($value);
                // 1. Generate a filename.
                $filename = md5($value.time()).'.jpg';
                // 2. Store the image on disk.
                Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                // 3. Save the path to the database
                array_push($imageArray, $destination_path.'/'.$filename);
            } else {
                array_push($imageArray, $value);
            }
        }
        // Update $request with new array

        foreach($imageArray as $key => $value){
            if($value == null) unset($imageArray[$key]);
        }

        $request->request->set($attribute_name, implode('|',$imageArray));
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
