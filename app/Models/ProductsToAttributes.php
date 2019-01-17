<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class ProductsToAttributes extends Model
{
    use CrudTrait;
    protected $table = 'products_to_attributes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['product_id', 'attribute_id', 'attribute_value_id'];
    // protected $hidden = [];
    // protected $dates = [];

    static function getProductAttributes($product_id)
    {
        $data = [];
        $values = ProductsToAttributes::where(['product_id' => $product_id])->get();
        if ($values)
            foreach ($values as $value) {
                $product_attributes = ProductsAttributesValue::where(['product_attributes_id' => $value->attribute_id])->get();
                $data [] = [
                    'data' => $value,
                    'values' => $product_attributes,
                ];
            }
        return $data;
    }
}