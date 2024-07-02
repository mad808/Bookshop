<?php /** @noinspection ALL */

namespace App\Http\Controllers\Client;

use App\Models\Brand;
use App\Models\Booklang;
use App\Models\Book;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100',
            'brands' => 'nullable|array|min:0',
            'brands.*' => 'nullable|integer|min:1',
            'years' => 'nullable|array|min:0',
            'years.*' => 'nullable|integer|min:1',
            'booklangs' => 'nullable|array|min:0',
            'booklangs.*' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|in:15,30,60,120',]);

        $search = $request->q ?: null;
        $f_brands = $request->has('brands') ? $request->brands : [];
        $f_years = $request->has('years') ? $request->years : [];
        $f_booklangs = $request->has('booklangs') ? $request->booklangs : [];
        $f_sort = $request->has('sort') ? $request->sort : null;
        $f_page = $request->has('page') ? $request->page : 1;
        $f_perPage = $request->has('perPage') ? $request->perPage : 15;

        $books = Book::when($f_brands, function ($query) use ($f_brands) {
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
            ->when($f_years, function ($query) use ($f_years) {
                $query->whereIn('year_id', $f_years);
            })

            ->with('brand', 'year', 'booklang')
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
        $years = Year::orderBy('name')
            ->get();
        $booklangs = Booklang::orderBy('name')
            ->get();

        return view('car.index')
            ->with([
                'books' => $books,
                'brands' => $brands,
                'years' => $years,
                'booklangs' => $booklangs,
                'f_brands' => $f_brands,
                'f_booklangs' => $f_booklangs,
                'f_perPage' => $f_perPage,
            ]);
    }


    public function show($id)
    {
        $book = Book::with('user', 'brand', 'year', 'booklang')
            ->findOrFail($id);

        $similar2 = Book::where('id', '!=', $id)
            ->with('brand', 'year', 'booklang')
            ->take(4)
            ->get();

        $similar = Book::where('brand_id', $book->brand->id)
            ->where('booklang_id', $book->booklang->id)
            ->where('year_id', $book->year->id)
            ->where('id', '!=', $id)
            ->with('brand', 'year', 'booklang')
            ->take(4)
            ->get();


        return view('car.show')
            ->with([
                'book' => $book,
                'similar' => $similar,
                'similar2' => $similar2,
            ]);
    }


    public function favorite($id)
    {
        $book = Book::where('id', $id)
            ->firstOrFail();

        if (Cookie::has('store_favorites')) {
            $cookies = explode(",", Cookie::get('store_favorites'));
            if (in_array($book->id, $cookies)) {
                $book->decrement('favorited');
                $index = array_search($book->id, $cookies);
                unset($cookies[$index]);
            } else {
                $book->increment('favorited');
                $cookies[] = $book->id;
            }
            Cookie::queue('store_favorites', implode(",", $cookies), 60 * 24);
        } else {
            $book->increment('favorited');
            Cookie::queue('store_favorites', $book->id, 60 * 24);
        }

        return redirect()->back();
    }



    public function create()
    {
        $brands = Brand::orderBy('id')
            ->get();
        $years = Year::orderBy('id')
            ->get();
        $booklangs = Booklang::orderBy('id')
            ->get();

        return view('car.create', [
            'brands' => $brands,
            'years' => $years,
            'booklangs' => $booklangs,
        ]);
    }


    public function store(Request $request)
    {
        $request->validatedData = $request -> validate ([
            'brand_id' => 'required|max:255',
            'year_id' => 'required|max:255',
            'booklang_id' => 'required|max:255',
            'bar_code' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'bookspage' => 'numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        // name
        $user = Auth::user()->id;
        $brand = Brand::find($request->brand_id) ?: null;
        $year = Year::find($request->year_id) ?: null;
        $booklang = Booklang::find($request->booklang_id) ?: null;
        $name = $request->name . ' ' . $request->name;
        $writertwo = $request->writertwo . ' ' . $request->writertwo;

        // book
        $book = new Book();
        $book->user_id = $user;
        $book->brand_id = $brand->id ?: $request->brand_id;
        $book->year_id = $year->id ?: $request->year_id;
        $book->booklang_id = $booklang->id ?: $request->booklang_id;
        $book->bar_code = $request->bar_code;
        $book->name = $name;
        $book->writertwo = $writertwo;
        $book->description = $request->description ?: null;
        $book->price = $request->price;
        $book->bookspage = $request->bookspage;

        // image
        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $newImageName = $book->id . '.' . $newImage->getClientOriginalExtension();
            $newImage->storeAs('public/kitaps/', $newImageName);
            $book->image = $newImageName;
        }

        $book->save();

        $success = trans('app.store-response', ['name' => $book->name]);
        return redirect()->route('books.show', $book->id)
            ->with([
                'success' => $success,
            ]);
    }


    public function edit($id)
    {
        $book = Book::where('id', $id)
            ->firstOrFail();
        $brands = Brand::orderBy('id')
            ->get();
        $years = Year::orderBy('id')
            ->get();
        $booklangs = Booklang::orderBy('id')
            ->get();

        return view('car.edit', [
            'book' => $book,
            'brands' => $brands,
            'years' => $years,
            'booklangs' => $booklangs,
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'year_id' => 'required|exists:years,id',
            'booklang_id' => 'required|exists:booklangs,id',
            'location_id' => 'required|exists:locations,id',
            'bar_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')->ignore($book->id)
            ],
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'bookspage' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);
        $user = Auth::user()->id;

        $book->user_id = $user;
        $book->brand_id = $request->brand_id;
        $book->year_id = $request->year_id;
        $book->booklang_id = $request->booklang_id;
        $book->name = $request->name;
        $book->writertwo = $request->writertwo;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->bookspage = $request->bookspage;

        // image
        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::delete('public/books/' . $book->image);
            }
            $newImage = $request->file('image');
            $newImageName = $book->id . '.' . $newImage->getClientOriginalExtension();
            $newImage->storeAs('public/books/', $newImageName);
            $book->image = $newImageName;
        }

        $book->save();

        $success = trans('app.update-response', ['name' => $book->name]);
        return redirect()->route('books.show', $book->id)
            ->with(['success' => $success]);
    }


    public function delete($id)
    {
        $book = Book::where('id', $id)
            ->firstOrFail();
        $success = trans('app.delete-response', ['name' => $book->name]);
        $book->delete();

        return redirect()->route('home')
            ->with([
                'success' => $success,
            ]);
    }

    public function userCars()
    {
        $books = Book::where('user_id', auth()->user()->id)
            ->with(['brand', 'year', 'booklang'])
            ->get();

        return view('car.userCars', [
            'books' => $books,
        ]);
    }
}
