<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function testConvertTaxInclude()
    {
        $model = new Product();
        $tax_rate = 1.1;

        $result = $model->convertTaxIncluded(100);
        $expected = 100 * $tax_rate;

        $this->assertSame($expected, $result);
    }

    public function testTotalPrice()
    {
        $model = new Product();

        $products = $model->where('id', '<', 3)->get()->all();
        $expected = 440;
        
        $result = $model->totalPrice($products);

        $this->assertEquals($expected, $result);
    }

}
