<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('pages.companies.index', compact('companies'));
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
            'name' => 'required|unique:companies'
        ]);

        $company = new Company();
        $company->name = $request->get('name') ?? null;
        $company->phone = $request->get('phone') ?? null;
        $company->email = $request->get('email') ?? null;
        $company->address = $request->get('address') ?? null;
        $company->description = $request->get('description') ?? null;
        $company->save();

        return redirect()->back()->with('success', 'Company added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('pages.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories'
        ]);
        $company->name = $request->get('name') ?? null;
        $company->phone = $request->get('phone') ?? null;
        $company->email = $request->get('email') ?? null;
        $company->address = $request->get('address') ?? null;
        $company->description = $request->get('description') ?? null;
        $company->save();

        return redirect()->back()->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->back()->with('success', 'Company deleted successfully!');
    }
}
