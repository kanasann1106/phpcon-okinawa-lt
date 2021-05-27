<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function testGetProducts()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    /**
     * @test
     * @expectedException Exception
     * @return void
     */
    public function testCreateProduct()
    {
        // 正常
        $data = [
            'name' => 'ちんすこう',
            'price' => 1200,
        ];
        $res = $this->createProductApi($data);
        $res->assertStatus(200);

        // エラー時
        $data = [
            'name' => '',
            'price' => 1200,
        ];
        $res = $this->createProductApi($data);
    }

    public function createProductApi($param)
    {
        return $this->post('/api/products', $param);
    }
}
