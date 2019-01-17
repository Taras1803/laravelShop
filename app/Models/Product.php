<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class Product extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'products';
     protected $primaryKey = 'id';
     public $timestamps = true;
     protected $guarded = ['id'];
    protected $fillable = ['images', 'image','status','slug','price','action_price','action','title','category_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            Storage::disk('public')->delete($obj->image);
        });
    }


    public function updateImageOrder($order) {
        $new_images_attribute = [];

        foreach ($order as $key => $image) {
            $new_images_attribute[$image['id']] = $image['path'];
        }
        $new_images_attribute = json_encode($new_images_attribute);

        $this->attributes['images'] = $new_images_attribute;
        $this->save();
    }

    public function removeImage($image_id, $image_path, $disk)
    {
        // delete the image from the db
        $images = json_encode(array_except($this->images, [$image_id]));
        $this->attributes['images'] = $images;
        $this->save();

        // delete the image from the folder
        if (Storage::disk($disk)->has($image_path)) {
            Storage::disk($disk)->delete($image_path);
        }
    }


    public function setImagesAttribute($value)
    {

        $attribute_name = "images";
        $disk = "public";
        $destination_path = "uploads/products";

        $this->attributes[$attribute_name] = $value;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function getProductDescription()
    {
        return $this->hasOne('App\Models\ProductsDescription',  'parent_id');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Categorie', 'category_id','id');
    }

    public function getMaterial()
    {
        return $this->belongsTo('App\Models\Material', 'material_id','id');
    }
    public function attributes()
    {
        return $this->belongsToMany('App\Models\Products_attribute','products_to_attributes','product_id','attribute_id')->withPivot( 'attribute_id','product_id','attribute_value_id');

    }

    static function getProductData($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $product['material'] = $product->getMaterial->name;
        $product['product_description'] = $product->getProductDescription->description;
        $data['product'] = $product;
        $data['categories'] = Categorie::all();
        return $data;
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
