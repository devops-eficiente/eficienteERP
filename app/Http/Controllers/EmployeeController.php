<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\BloodType;
use App\Models\Employee;
use App\Models\IdentificationEmployee;
use App\Models\InstituteHealth;
use App\Models\MaritalStatus;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);
        // return $employees;
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $bloodTypes = BloodType::all();
        $instituteHealths = InstituteHealth::all();
        $maritalStatus = MaritalStatus::all();
        $identificationEmployees = IdentificationEmployee::all();
        return view('employee.create', compact('bloodTypes', 'instituteHealths', 'maritalStatus', 'identificationEmployees'));
    }
    public function store(EmployeeStoreRequest $request)
    {
        try {
            $data = $request->all();
            $ult = Employee::max('id') + 1;
            $data['n_employee'] = 'E' . $ult;
            DB::beginTransaction();
            Employee::create($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('denied', $th->getMessage());
        }
        return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
    }
}
