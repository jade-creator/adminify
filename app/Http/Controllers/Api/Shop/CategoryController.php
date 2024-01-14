<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LogicException;
use Spatie\RouteAttributes\Attributes\ApiResource;
use Spatie\RouteAttributes\Attributes\Middleware;

/**
 * @tags Category
 */
#[Middleware('auth:sanctum')]
#[ApiResource(resource: 'categories', only: ['index'])]
class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        try {
            $data = CategoryResource::collection(Category::orderBy('name')->get());
        } catch (Exception $e) {
            report($e);

            throw new LogicException($e->getMessage());
        }

        return response([
            'data' => $data
        ]);
    }
}
