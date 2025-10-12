<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('view users');
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $this->authorize('create users');
        $roles = Role::pluck('name');
        return view('users.create', compact('roles'));
    }

    public function show($id)
    {
        $this->authorize('view users');
        return 'show';
    }

    public function store(Request $request)
    {
        $this->authorize('create users');
        return view('users.store');
    }
    public function edit($id)
    {
        $this->authorize('update users');
        return view('users.edit');
    }
    public function update(Request $request, $id)
    {
        $this->authorize('update users');
        return view('users.update');
    }

    public function destroy($id)
    {
        return view('users.destroy');
    }
}
