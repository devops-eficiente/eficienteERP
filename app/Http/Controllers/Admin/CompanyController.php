<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyEditRequest;
use App\Models\Company;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(){
        $companies = Company::paginate(15);
        return view('admin.company.index',compact('companies'));
    }

    public function create(){
        $modules = Module::all();
        return view('admin.company.create', compact('modules'));
    }

    public function store(CompanyCreateRequest $request){
        try {
            DB::beginTransaction();
            $company = Company::create([
                'bussines_name' => $request->bussines_name,
                'rfc' => $request->rfc,
                'email' => $request->email,
                'phone' => $request->telephone,
            ]);

            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'password' => $request->user_password,
                'company_id' => $company->id
            ]);
            $user->assignRole('admin_empresa');
            $company->modules()->attach($request->modules);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // return $th->getMessage();
            return back()->with('denied','Sucedio un error: '.$th->getMessage());
        }
        return redirect()->route('admin.company.index')->with('success','Empresa creada correctamente.');
    }

    public function edit($rfc){
        $company = Company::where('rfc',$rfc)->first();
        $modules = Module::all();
        return view('admin.company.edit', compact('modules','company'));
    }

    public function update(CompanyEditRequest $request, Company $company){
        try {
            DB::beginTransaction();
            $company->update([
                'bussines_name' => $request->bussines_name,
                'rfc' => $request->rfc,
                'email' => $request->email,
                'phone' => $request->telephone,
            ]);

            $company->modules()->sync($request->modules);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // return $th->getMessage();
            return back()->with('denied','Sucedio un error: '.$th->getMessage());
        }
        return redirect()->route('admin.company.index')->with('success','Cambios guardados correctamente.');
    }
}
