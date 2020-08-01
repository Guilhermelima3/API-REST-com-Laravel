<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
	{
		$this->product = $product;
	}

    /**
     * List all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return response()->json($this->product->all());
    }

    /**
     * Display a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$product = $this->product->find($id);

    	if(! $product) return response()->json(ApiError::errorMessage('Produto não encontrado!', 4040), 404);

    	$data = ['data' => $product];
	    return response()->json($data);
    }
   
    public function store(Request $request)
    {
		try {

			$productData = $request->all();
			$this->product->create($productData);

			$return = ['data' => ['msg' => 'Produto criado com sucesso!']];
			return response()->json($return, 201);

		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1010), 500);
			} 
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de salvar', 1010),  500);
		}
    }


    /**
     * Update a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

			$productData = $request->all();
            $product = $this->product->find($id);
            $product->update($productData);

			$return = ['data' => ['msg' => 'Produto atualizado com sucesso!']];
			return response()->json($return, 201);

		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1011), 500);
			} 
			return response()->json(ApiError::errorMessage('Houve um erro ao atualizar', 1011),  500);
		}
    }

    /**
     * Remove a product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $id)
    {
        try{
            $id->delete();
            return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso!']], 200);
       
        }catch(\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1012), 500);
			} 
			return response()->json(ApiError::errorMessage('Houve um erro ao deletar', 1012),  500);
		}
    }
}
