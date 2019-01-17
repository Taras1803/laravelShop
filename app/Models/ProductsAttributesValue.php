<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class ProductsAttributesValue extends Model
{
    use CrudTrait;

    protected $table = 'products_attributes_values';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['product_attributes_id', 'value',];
    // protected $hidden = [];
    // protected $dates = [];



    public function getProductAttribute()
    {
        return $this->hasOne('App\Models\Products_attribute');
    }

    static function getProductAttributes($product_id)
    {
        $data = [];
        $values = self::where(['product_id' => $product_id])->orderBy(['attribute_id' => SORT_ASC])->all();
        if ($values)
            foreach ($values as $value) {
                $product_attributes = ProductsAttributesValue::where(['product_attributes_id' => $value->attribute_id])->all();
                $data [] = [
                    'data' => $value,
                    'values' => $product_attributes,
                ];
            }
        return $data;
    }
}