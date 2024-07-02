<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'sort' => 'nullable|string|in:top-to-bottom,bottom-to-top,start-to-end,end-to-start',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|in:10,25,50,100',
        ]);

        $q = $request->q ?: null;
        $f_sort = $request->has('sort') ? $request->sort : null;
        $f_page = $request->has('page') ? $request->page : 1;
        $f_perPage = $request->has('perPage') ? $request->perPage : 10;

        $objs = Contact::when($q, function ($query, $q) {
    return $query->where(function ($query) use ($q) {
        $query->orWhere('company', 'like', '%' . $q . '%');
        $query->orWhere('phone', 'like', '%' . $q . '%');
        $query->orWhere('name', 'like', '%' . $q . '%');
        $query->orWhere('email', 'like', '%' . $q . '%');
    });
})
            ->when(isset($f_sort), function ($query) use ($f_sort) {
                if ($f_sort == 'bottom-to-top') {
                    $query->orderBy('id', 'desc');
                } elseif ($f_sort == 'top-to-bottom') {
$query->orderBy('id');
} elseif ($f_sort == 'start-to-end') {
$query->orderBy('created_at');
} elseif ($f_sort == 'end-to-start') {
$query->orderBy('created_at', 'desc');
} else {
    $query->orderBy('id');
}
}, function ($query) {
    $query->orderBy('id');
})
->paginate($f_perPage, ['*'], 'page', $f_page)
    ->withQueryString();

return view('admin.note.index')
    ->with([
        'q' => $q,
        'objs' => $objs,
        'f_sort' => $f_sort,
        'f_perPage' => $f_perPage,
    ]);
}

/**
 * Remove the specified resource from storage.
 *
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */

public function destroy($id)
{

    $obj = Contact::findOrFail($id);
    $objName = $obj->name;
    $obj->delete();

    return redirect()->back()
        ->with([
            'success' => trans('app.note') . ' (' . $objName . ') ' . trans('app.deleted') . '!'
        ]);
}
}
