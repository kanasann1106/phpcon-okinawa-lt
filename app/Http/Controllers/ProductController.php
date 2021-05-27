<?php
 
namespace App\Http\Controllers;
 
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
 
class ProductController extends Controller
{
    /**
     * 商品登録
     *
     * @param Request $request
     * @return Json
     */
    public function createProduct(Request $request)
    {
        if (empty($request->name) && empty($request->price)) {
            throw new Exception('value is empty');
        }

        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->save();

            DB::commit();
            return response()->json([
                'product' => $product
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'result' => 'error',
                'exception' => $e->getMessage()
            ]);
        }

    }

    /**
     * 全商品を取得
     *
     * @return Json
     */
    public function getProducts()
    {   
        $response = [];
        $products = Product::all();

        if (empty($products)) {
            return response()->json($response);
        }

        foreach ($products as $product) {
            $product->tax_included_price = Product::convertTaxincluded($product->price);
        }
        
        $total_price = Product::totalPrice($products);
        $response = [
            'products' => $products,
            'total_price' => $total_price
        ];
        
        return response()->json($response);   
    }
}