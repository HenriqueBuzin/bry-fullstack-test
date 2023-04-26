<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return response()->json(['employees' => $employees], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'login' => 'required|max:255',
            'name' => 'required|max:255',
            'cpf' => 'required|unique:employees|max:14',
            'email' => 'required|unique:employees|max:255',
            'address' => 'required|max:255',
            'password' => 'required|max:255',
            'company_id' => 'required'
        ]);

        $employee = Employee::create($validatedData);

        return response()->json(['employee' => $employee], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json(['employee' => $employee], 200);
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'login' => 'required|max:255',
            'name' => 'required|max:255',
            'cpf' => 'required|unique:employees,cpf,'.$employee->id.'|max:14',
            'email' => 'required|unique:employees,email,'.$employee->id.'|max:255',
            'address' => 'required|max:255',
            'password' => 'required|max:255',
            'company_id' => 'required'
        ]);

        $employee->update($validatedData);

        return response()->json(['employee' => $employee], 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(null, 204);
    }
}
