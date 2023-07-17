<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $categories = Category::take(6)->get();
        $keyword = $request->search;
        $products = Product::where('name', 'LIKE' , '%'. $keyword . '%' )
            ->orWhereHas('category', function($query) use($keyword){
                $query->where('name', 'LIKE', '%'. $keyword .'%');
            })
            ->take(8)->get();
        return view('pages.home',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
