<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Shop\Product\ProductBulkDeleteRequest;
use App\Http\Requests\Api\Shop\Product\ProductsRequest;
use App\Http\Requests\Api\Shop\Product\ProductStoreRequest;
use App\Http\Requests\Api\Shop\Product\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use LogicException;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\ApiResource;
use Spatie\RouteAttributes\Attributes\Middleware;

/**
 * @tags Product
 */
#[Middleware('auth:sanctum')]
#[ApiResource(resource: 'products', only: ['index', 'store', 'update', 'show'])]
class ProductController extends Controller
{
    public function index(ProductsRequest $request)
    {
        $searchQuery = $request->input('search');
        $categoryFilter = $request->input('category');

        try {
            $data = new ProductCollection(
                Product::query()
                ->with('category')
                ->when(filled($searchQuery), function ($query) use ($searchQuery) {
                    $query->where('name', 'like', "%{$searchQuery}%")
                        ->orWhere('description', 'like', "%{$searchQuery}%");
                })
                ->when(filled($categoryFilter), function ($query) use ($categoryFilter) {
                    $query->where('category_id', $categoryFilter);
                })
                ->latest()
                ->paginate()
            );
        } catch (Exception $e) {
            report($e);

            throw new LogicException('Something went wrong!');
        }

        return $data;
    }

    #[Delete(uri: '/products', name: 'products.destroy')]
    public function destroy(ProductBulkDeleteRequest $request): Response
    {
        try {
            $products = Product::whereIn('id', $request->input('ids'))->get();

            $products->each(function ($product) {
                $product->clearMediaCollection('images');

                $product->delete();
            });
        } catch (Exception $e) {
            report($e);

            throw new LogicException('Something went wrong!');
        }

        return response([
            'message' => trans('Product Deleted.')
        ]);
    }

    public function store(ProductStoreRequest $request): Response
    {
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'date_and_time' => $request->date_and_time,
                ]);

                if ($request->hasFile('images')) {
                    $product->addMultipleMediaFromRequest(['images'])
                        ->each(function ($fileAdder) {
                            $fileAdder->toMediaCollection('images');
                        });
                }
            });
        } catch (Exception $e) {
            report($e);

            throw new LogicException('Something went wrong!');
        }

        return response([
            'message' => trans('Product Created!')
        ]);
    }

    public function show(Product $product): Response
    {
        $product->load(['media', 'category']);

        return response([
            'data' => ProductResource::make($product)
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): Response
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $product->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'date_and_time' => $request->date_and_time,
                ]);

                $product->clearMediaCollection('images');

                if ($request->hasFile('images')) {
                    $product->addMultipleMediaFromRequest(['images'])
                        ->each(function ($fileAdder) {
                            $fileAdder->toMediaCollection('images');
                        });
                }
            });
        } catch (Exception $e) {
            report($e);

            throw new LogicException('Something went wrong!');
        }

        return response([
            'message' => trans('Product Updated!')
        ]);
    }
}
