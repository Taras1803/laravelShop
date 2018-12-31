<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class CategoriesDescription extends Model
{
    use CrudTrait;


    protected $table = 'categories_descriptions';
    protected $primaryKey = 'id';
    public $timestamps = true;
//    protected $guarded = ['id'];
    protected $fillable = ['name','description', 'parent_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Categorie', 'parent_id');

    }
}