<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(8)->get();

        return view('home', compact('products'));
    }

    public function shop(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('brand', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand', mb_strtoupper($request->brand));
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Product::select('brand')->distinct()->whereNotNull('brand')->pluck('brand');

        return view('shop', compact('products', 'brands'));
    }

    public function show(Product $product)
    {
        $related = $product->brand
            ? Product::where('brand', $product->brand)->where('id', '!=', $product->id)->take(4)->get()
            : collect();

        return view('product', compact('product', 'related'));
    }
}