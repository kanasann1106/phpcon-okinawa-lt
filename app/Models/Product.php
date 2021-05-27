<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
    ];

    /**
     * 税込価格に変換
     *
     * @param int $price
     * @return int
     */
    public static function convertTaxIncluded($price)
    {
        $tax_rate = 1.1;
        
        $tax_included = $price * $tax_rate;
    
        return floor($tax_included);
    }

    /**
     * 商品の合計金額(税込)
     *
     * @param Collection $products
     * @return int
     */
    public static function totalPrice($products)
    {
        $total_price = 0;

        foreach ($products as $product) {
            $total_price += $product->price;
        }

        return self::convertTaxIncluded($total_price);
    }
}
