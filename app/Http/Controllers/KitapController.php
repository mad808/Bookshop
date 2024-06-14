<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Booklang;
use App\Models\Kitap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class KitapController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100',
            'brands' => 'nullable|array|min:0',
            'brands.*' => 'nullable|integer|min:1',
            'booklangs' => 'nullable|array|min:0',
            'booklangs.*' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|in:15,30,60,120',]);

        $search = $request->q ?: null;
        $f_brands = $request->has('brands') ? $request->brands : [];
        $f_booklangs = $request->has('booklangs') ? $request->booklangs : [];
        $f_sort = $request->has('sort') ? $request->sort : null;
        $f_page = $request->has('page') ? $request->page : 1;
        $f_perPage = $request->has('perPage') ? $request->perPage : 15;

        $kitaps = Kitap::when($f_brands, function ($query) use ($f_brands) {
            $query->whereIn('brand_id', $f_brands);
        })
            ->
            when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'ilike', '%' . $search . '%');
                });
            })
            ->when($f_booklangs, function ($query) use ($f_booklangs) {
                $query->whereIn('booklang_id', $f_booklangs);
            })

            ->with('brand', 'booklang')
            ->when(isset($f_sort), function ($query) use ($f_sort) {
                if ($f_sort == 'old-to-new') {
                    $query->orderBy('id');
                } else {
                    $query->orderBy('id', 'desc');
                }
            }, function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->paginate($f_perPage, ['*'], 'page', $f_page)
            ->withQueryString();

        $brands = Brand::orderBy('name')
            ->get();
        $booklangs = Booklang::orderBy('name')
            ->get();

        return view('car.index')
            ->with([
                'kitaps' => $kitaps,
                'brands' => $brands,
                'booklangs' => $booklangs,
                'f_brands' => $f_brands,
                'f_booklangs' => $f_booklangs,
                'f_perPage' => $f_perPage,
            ]);
    }


    public function show($id)
    {
        $kitap = Kitap::with('user', 'brand', 'booklang')
            ->findOrFail($id);

        $similar2 = Kitap::where('id', '!=', $id)
            ->with('brand', 'booklang')
            ->take(4)
            ->get();

        $similar = Kitap::where('brand_id', $kitap->brand->id)
            ->where('booklang_id', $kitap->booklang->id)
            ->where('id', '!=', $id)
            ->with('brand', 'booklang')
            ->take(4)
            ->get();


        return view('car.show')
            ->with([
                'kitap' => $kitap,
                'similar' => $similar,
                'similar2' => $similar2,
            ]);
    }


    public function favorite($id)
    {
        $kitap = Kitap::where('id', $id)
            ->firstOrFail();

        if (Cookie::has('store_favorites')) {
            $cookies = explode(",", Cookie::get('store_favorites'));
            if (in_array($kitap->id, $cookies)) {
                $kitap->decrement('favorited');
                $index = array_search($kitap->id, $cookies);
                unset($cookies[$index]);
            } else {
                $kitap->increment('favorited');
                $cookies[] = $kitap->id;
            }
            Cookie::queue('store_favorites', implode(",", $cookies), 60 * 24);
        } else {
            $kitap->increment('favorited');
            Cookie::queue('store_favorites', $kitap->id, 60 * 24);
        }

        return redirect()->back();
    }



    public function create()
    {
        $brands = Brand::orderBy('id')
            ->get();
        $booklangs = Booklang::orderBy('id')
            ->get();

        return view('car.create', [
            'brands' => $brands,
            'booklangs' => $booklangs,
        ]);
    }


    public function store(Request $request)
    {
        $request->validatedData = $request -> validate ([
            'brand_id' => 'required|max:255',
            'booklang_id' => 'required|max:255',
            'probeg' => 'required|string|max:255',
            'bar_code' => 'required|string|max:255|unique:cars',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        // name
        $user = Auth::user()->id;
        $brand = Brand::findOrFail($request->brand_id);
        $booklang = Booklang::findOrFail($request->booklang_id);
        $name = $brand->name . ' ' . $request->name;

        // kitap
        $kitap = new Kitap();
        $kitap->user_id = $user;
        $kitap->brand_id = $brand->id;
        $kitap->booklang_id = $booklang->id;
        $kitap->bar_code = $request->bar_code;
        $kitap->name = $name;
        $kitap->description = $request->description ?: null;
        $kitap->price = $request->price;

        // image
        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $newImageName = $kitap->id . '.' . $newImage->getClientOriginalExtension();
            $newImage->storeAs('public/kitaps/', $newImageName);
            $kitap->image = $newImageName;
        }

        $kitap->save();

        $success = trans('app.store-response', ['name' => $kitap->name]);
        return redirect()->route('kitaps.show', $kitap->id)
            ->with([
                'success' => $success,
            ]);
    }


    public function edit($id)
    {
        $kitap = Kitap::where('id', $id)
            ->firstOrFail();
        $brands = Brand::orderBy('id')
            ->get();
        $booklangs = Booklang::orderBy('id')
            ->get();

        return view('kitap.edit', [
            'kitap' => $kitap,
            'brands' => $brands,
            'booklangs' => $booklangs,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kitap = Kitap::findOrFail($id);

        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'booklang_id' => 'required|exists:colors,id',
            'location_id' => 'required|exists:locations,id',
            'bar_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kitaps')->ignore($kitap->id)
            ],
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);
        $user = Auth::user()->id;

        $kitap->user_id = $user;
        $kitap->brand_id = $request->brand_id;
        $kitap->booklang_id = $request->booklang_id;
        $kitap->name = $request->name;
        $kitap->description = $request->description;
        $kitap->price = $request->price;

        // image
        if ($request->hasFile('image')) {
            if ($kitap->image) {
                Storage::delete('public/kitaps/' . $kitap->image);
            }
            $newImage = $request->file('image');
            $newImageName = $kitap->id . '.' . $newImage->getClientOriginalExtension();
            $newImage->storeAs('public/kitaps/', $newImageName);
            $kitap->image = $newImageName;
        }

        $kitap->save();

        $success = trans('app.update-response', ['name' => $kitap->name]);
        return redirect()->route('kitaps.show', $kitap->id)
            ->with(['success' => $success]);
    }


    public function delete($id)
    {
        $kitap = Kitap::where('id', $id)
            ->firstOrFail();
        $success = trans('app.delete-response', ['name' => $kitap->name]);
        $kitap->delete();

        return redirect()->route('home')
            ->with([
                'success' => $success,
            ]);
    }

    public function userCars()
    {
        $kitaps = Kitap::where('user_id', auth()->user()->id)
            ->with(['brand', 'booklang'])
            ->get();

        return view('kitap.userCars', [
            'kitaps' => $kitaps,
        ]);
    }
}
