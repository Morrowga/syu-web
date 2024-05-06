<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository,CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('category');

        if(!$categoryId)
        {
            return redirect()->route('product-home');
        }

        $products = $this->productRepository->index();
        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('ProductHome/Product/Index', [
            "products" => $products['data'],
            "category" => $category['data']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoryId = $request->query('category');

        if(!$categoryId)
        {
            return redirect()->route('product-home');
        }

        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('ProductHome/Product/Create', [
            "category" => $category['data']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        $createProduct = $this->productRepository->store($request);

        Session::flash('message', $createProduct['message']);

        return redirect()->route('products.index', ['category' => $request->category_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('ProductHome/Product/Edit',[
            "product" => $product->load('category')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $updateProduct = $this->productRepository->update($request,$product);

        Session::flash('message', $updateProduct['message']);

        return redirect()->route('products.index', ['category' => $product->category_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $deleteProduct = $this->productRepository->delete($product);

        return redirect()->route('products.index', ['category' => $product->category_id]);
    }

    public function setStatus(Request $request, Product $product)
    {
        $setStatusProduct = $this->productRepository->setStatus($request, $product);

        return redirect()->route('products.index', ['category' => $product->category_id]);
    }
}
