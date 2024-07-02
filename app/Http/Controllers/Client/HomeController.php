<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::take(5)
            ->get();

        $brandBooks = [];
        foreach ($brands as $brand) {
            $brandBooks[] = [
                'brand' => $brand,
                'books' => Book::where('brand_id', $brand->id)
                    ->with('brand', 'year', 'booklang')
                    ->take(4)
                    ->get(),
            ];
        }


        return view('home.index')
            ->with([
                'brandBooks' => $brandBooks,
            ]);
    }




    public function locale($locale)
    {
        if ($locale == 'en') {
            session()->put('locale', 'en');
            return redirect()->back();
        }

        elseif ($locale == 'tm') {
            session()->put('locale', 'tm');
            return redirect()->back();
        }

        elseif ($locale == 'ru') {
            session()->put('locale', 'ru');
            return redirect()->back();
        }


        elseif ($locale == 'tr') {
            session()->put('locale', 'tr');
            return redirect()->back();
        }

        else {
            return redirect()->back();
        }
    }
}
