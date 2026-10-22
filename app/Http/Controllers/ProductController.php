<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private ProductServiceInterface $productService
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        $products = $this->productService->getProducts(
            $request->string('search')->toString(),
            10
        );

        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.partials.table', compact('products'))->render(),
                'pagination' => $products->links()->render(),
            ]);
        }

        return view('products.index', compact('products'));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct(
            $request->validated()
        );

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    public function show(int $product): JsonResponse
    {
        return response()->json(
            $this->productService->getProduct($product)
        );
    }

    public function update(
        UpdateProductRequest $request,
        int $product
    ): JsonResponse {
        $updatedProduct = $this->productService->updateProduct(
            $product,
            $request->validated()
        );

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $updatedProduct,
        ]);
    }

    public function destroy(int $product): JsonResponse
    {
        $this->productService->deleteProduct($product);

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}