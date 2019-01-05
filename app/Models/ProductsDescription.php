<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ProductsDescription extends Model
{
    use CrudTrait;


    protected $table = 'products_descriptions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['name','description', 'parent_id'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id');

    }
}