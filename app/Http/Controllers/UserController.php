<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::role('usuario_empresa')
            ->where('company_id', auth()->user()->company_id)
            ->paginate(15);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['company_id'] = auth()->user()->company_id;
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            $user->assignRole('usuario_empresa');
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('denied', 'Sucedio un error: ' . $th->getMessage());
        }
        return redirect()->route('admin.user.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            if ($request->password) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('denied', 'Sucedio un error: ' . $th->getMessage());
        }
        return redirect()->route('admin.user.index')->with('success', 'Usuario editado correctamente.');
    }
}
