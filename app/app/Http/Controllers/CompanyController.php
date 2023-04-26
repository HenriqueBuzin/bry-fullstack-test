<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cnpj' => [
                'required',
                'unique:companies',
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/'
            ],
            'address' => 'required|max:255',
        ]);

        $company = new Company();
        $company->name = $validatedData['name'];
        $company->cnpj = $validatedData['cnpj'];
        $company->address = $validatedData['address'];
        $company->save();

        return response()->json($company, 201);
    }

    public function show(Company $company)
    {
        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cnpj' => [
                'required',
                Rule::unique('companies')->ignore($company->id),
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/'
            ],
            'address' => 'required|max:255',
        ]);

        $company->name = $validatedData['name'];
        $company->cnpj = $validatedData['cnpj'];
        $company->address = $validatedData['address'];
        $company->save();

        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([], 204);
    }
}
