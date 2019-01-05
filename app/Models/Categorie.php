<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class Categorie extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
     protected $primaryKey = 'id';
     public $timestamps = true;
     protected $guarded = ['id'];
    protected $fillable = ['image', 'status','slug','title'];
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
        $destination_path = "/uploads/categories";

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

    static function getCatalogData()
    {
        $data['categories'] = Categorie::where('status','=','on')->get();
        $data['products'] = Product::where('status','=','on')->paginate(Config::get('settings.product_per_page'));
        return $data;
    }
    static function getCategoryData($slug)
    {
        $category = Categorie::where('slug', $slug)->first();
        $data['category_description'] = $category->getCategoryDescription->description;
        $products = $category->products()->paginate(Config::get('settings.product_per_page'));
        foreach ($products as $key => $product){
            $products[$key]['material'] = $product->getMaterial->name;
        }
        $data['categories'] = Categorie::all();
        $data['products'] = $products;
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function getCategoryDescription()
    {
        return $this->hasOne('App\Models\CategoriesDescription',  'parent_id');

    }
    public function products()
    {
        return $this->hasMany('App\Models\Product',  'category_id');

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
