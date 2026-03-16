<?php

namespace App\Http\Controllers;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->productService->list();
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        return $this->productService->create($data);
    }

    public function show(int $id)
    {
        $product = $this->productService->findById($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produto não encontrado ou já foi removido.'
            ], 404);
        }

        return response()->json($product);
    }

    public function update(int $id)
    {
        $data = request()->validate([
            'name' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric',
        ]);

        return $this->productService->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->productService->delete($id);
    }
    
    public function restore($id)
    {
        $product = $this->productService->restoreProduct($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado nos excluídos'], 404);
        }

        return response()->json([
            'message' => 'Produto restaurado com sucesso',
            'product' => $product
        ]);
    }
}