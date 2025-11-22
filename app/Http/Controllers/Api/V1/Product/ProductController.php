<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends ApiBaseController
{
    /**
     * List products.
     */
    public function index(Request $request): JsonResponse
    {
        // Product list with pagination
        $products = Product::paginate($request->input('per_page', 10));

        return $this->okResponse(['products' => $products], __('Products retrieved successfully.'));
    }

    /**
     * Show a specific product.
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->notFoundResponse([], __('Product not found'));
        }

        return $this->okResponse(['product' => $product], __('Product retrieved successfully.'));
    }

    /**
     * Store a new product.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $product = Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
            ]);

            return $this->createdResponse(['product' => $product], __('Product created successfully.'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Product creation error: ' . $e->getMessage());

            return $this->serverErrorResponse(['error' => $e->getMessage()], __('Product creation failed'));
        }
    }

    /**
     * Update a product.
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return $this->notFoundResponse([], __('Product not found'));
            }

            $validatedData = $request->validated();

            $product->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
            ]);

            return $this->okResponse(['product' => $product], __('Product updated successfully.'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Product update error: ' . $e->getMessage());

            return $this->serverErrorResponse(['error' => $e->getMessage()], __('Product update failed'));
        }
    }

    /**
     * Delete a product.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return $this->notFoundResponse([], __('Product not found'));
            }

            $product->delete();

            return $this->okResponse([], __('Product deleted successfully.'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Product deletion error: ' . $e->getMessage());

            return $this->serverErrorResponse(['error' => $e->getMessage()], __('Product deletion failed'));
        }
    }
}
