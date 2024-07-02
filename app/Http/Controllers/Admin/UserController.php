<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $objs = User::orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.citizen.index')
            ->with([
                'objs' => $objs,
            ]);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */
public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.citizen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:16'],
        'secondName' => ['required', 'string', 'max:16'],
        'thirdName' => ['required', 'string', 'max:16'],
        'passport' => ['required', 'string', Rule::unique('users')],
//        'phone' => ['required','integer','min:61000000','max:65999999'],
        'gender' => ['required', 'boolean','min:0', 'max:1'],
        'country' => ['required', 'integer','min:1', 'max:6'],
        'password' => ['required', 'string', 'min:4', 'max:16', 'confirmed', Rules\Password::defaults()],
    ]);

    $obj = User::create([
        'name' => $request->name,
        'role' => $request->role,
//        'phone' => $request->phone,
//        'phone_2' => $request->phone_2 ?: null,
        'status' => $request->status,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'permissions' => $request->permissions ?: [],
    ]);

    return to_route('admin.users.index')
        ->with([
            'success' => trans('app.citizen') . ' (' . $obj->name . ') ' . trans('app.added') . '!'
        ]);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $obj = User::findOrFail($id);

        return view('admin.citizen.show')
            ->with([
                'obj' => $obj,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $obj = User::findOrFail($id);

        return view('admin.citizen.edit')
            ->with([
                'obj' => $obj,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    //
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
{

    $obj = User::findOrFail($id);
    $objName = $obj->name;
    $obj->delete();

    return redirect()->back()
        ->with([
            'success' => trans('app.citizen') . ' (' . $objName . ') ' . trans('app.deleted') . '!'
        ]);
}
}
