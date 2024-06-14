<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Kitap;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::take(5)
            ->get();

        $brandKitaps = [];
        foreach ($brands as $brand) {
            $brandKitaps[] = [
                'brand' => $brand,
                'kitaps' => Kitap::where('brand_id', $brand->id)
                    ->with('brand', 'booklang')
                    ->take(4)
                    ->get(),
            ];
        }


        return view('home.index')
            ->with([
                'brandKitaps' => $brandKitaps,
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
