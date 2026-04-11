<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Show all employees with optional search
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Employee::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%");
        });
    }

    $employees = $query->orderBy('id', 'desc')->paginate(5);

    // 🔥 REAL total salary (all data, not paginated)
    $totalSalary = $query->sum('salary');

    return view('employees.index', compact('employees', 'totalSalary'));
}

    // Show form to create employee
    public function create()
    {
        return view('employees.create');
    }

    // Store new employee
   public function store(Request $request)
{
    if (!auth()->user()->isAdmin() && !auth()->user()->isHr()) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email',
        'position' => 'required|string|max:255',
        'salary' => 'required|numeric|min:0',
    ]);

    Employee::create($request->all());

    return redirect()->route('employees.index')
        ->with('success', 'Employee added successfully!');
}

    // Show form to edit employee
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // Update existing employee
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully!');
    }

    // Delete employee
   public function destroy(Employee $employee)
{
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Only admin can delete employees');
    }

    $employee->delete();

    return redirect()->route('employees.index')
        ->with('success', 'Employee deleted successfully!');
}
}