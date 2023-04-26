<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    public function show($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }
        return response()->json($company);
    }

    public function store(Request $request)
    {
        $company = new Company();
        $company->name = $request->input('name');
        $company->cnpj = $request->input('cnpj');
        $company->address = $request->input('address');
        $company->save();
        return response()->json($company, 201);
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }
        $company->name = $request->input('name');
        $company->cnpj = $request->input('cnpj');
        $company->address = $request->input('address');
        $company->save();
        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }
        $company->delete();
        return response()->json(['message' => 'Empresa removida com sucesso']);
    }
}
