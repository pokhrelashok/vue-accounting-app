<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $companies = Company::all();


        return view('pages.users.index', compact('users','companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email') ?? null;
        $user->password = bcrypt($request->get('password'));
        $user->company_id = $request->get('company');
        $user->save();

        return redirect()->back()->with('success', 'user added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $companies = Company::all();


        return view('pages.users.edit', compact('user','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user->name = $request->get('name');
        $user->email = $request->get('email') ?? null;
        $user->company_id = $request->get('company') ?? null;
        $password = $request->get("password");
        $password ? $user->password = bcrypt($password) :'';
        $user->save();

        return redirect()->back()->with('success', 'user added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
