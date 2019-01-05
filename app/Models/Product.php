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
    protected $fillable = ['image', 'status','slug','price','action_price','action','title','category_id'];
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

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "/uploads/products";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {

            // 0. Make the image
            $image = Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
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
