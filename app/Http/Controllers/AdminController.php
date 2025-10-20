<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Admin::class);

        $admins = Admin::with(['user', 'user.roles'])->latest()->paginate(10);

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        $this->authorize('create', Admin::class);

        $roles = Role::all();

        return view('admins.create', compact('roles'));
    }

    public function show($id){
        $this->authorize('viewAny', Admin::class);

        $admin = Admin::findOrFail($id);

        return view('admins.show', compact('admin'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Admin::class);
      
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'first_name_ar' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'second_name_ar' => 'required|string|max:255',
            'second_name_en' => 'required|string|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'status' => 'nullable|string|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        $avatarPath = null;
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(storage_path('app/public/admins'), $avatarName);
            $avatarPath = 'storage/admins/' . $avatarName;
        }

        try {

            \DB::beginTransaction();

            $user = User::create([
                'avatar' => $avatarPath,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'first_name' => [
                    'ar' => $request->first_name_ar,
                    'en' => $request->first_name_en,
                ],
                'second_name' => [
                    'ar' => $request->second_name_ar,
                    'en' => $request->second_name_en,
                ],
                'bio' => [
                    'ar' => $request->bio_ar,
                    'en' => $request->bio_en,
                ],
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'status' => $request->status,
                'avatar' => $avatarPath,
                'roles' => $request->roles,
                'address' => $request->address,
            ]);

            $role = Role::where('name', 'admin')->first();
            if($role){
                $user->assignRole('admin');
            }else{
                Role::create(['name' => 'admin']);
                $user->assignRole('admin');
            }

            $admin = Admin::create([
                'user_id' => $user->id,
            ]);

            \DB::commit();
            return redirect()->route('admins.index')->with('success', 'Admin created successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
    }

    public function edit($admin)
    {
        $this->authorize('update', Admin::class);

        $admin = Admin::findOrFail($admin)->load('user');
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id) {
        $this->authorize('update', Admin::class);
        $admin = Admin::findOrFail($id);
        $validatedData = $request->validate([
            'email' => 'nullable|email|max:255|unique:users,email,' . $admin->user->id,
            'phone' => 'nullable|string|max:255|unique:users,phone,' . $admin->user->id,
            'first_name_ar' => 'nullable|string|max:255',
            'first_name_en' => 'nullable|string|max:255',
            'second_name_ar' => 'nullable|string|max:255',
            'second_name_en' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|string|min:8',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'status' => 'nullable|string|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        $avatarPath = null;
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(storage_path('app/public/admins'), $avatarName);
            $avatarPath = 'storage/admins/' . $avatarName;
        }


        $userData = [

            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'first_name' => [
                'ar' => $validatedData['first_name_ar'],
                'en' => $validatedData['first_name_en'],
            ],
            'second_name' => [
                'ar' => $validatedData['second_name_ar'],
                'en' => $validatedData['second_name_en'],
            ],
            'bio' => [
                'ar' => $validatedData['bio_ar'],
                'en' => $validatedData['bio_en'],
            ],
            'birth_date' => $validatedData['birth_date'],
            'gender' => $validatedData['gender'],
            'status' => $validatedData['status'],
            'avatar' => $avatarPath ?? $admin->user->avatar,
        ];


        if($validatedData['password']) {
            $userData['password'] = $validatedData['password'];
        }


        $user = $admin->user;

        $user->update($userData);


        return redirect()->route('admins.index')->with('success', 'Admin updated successfully');
    }

    public function destroy($id) {
        $this->authorize('delete',Admin::class);

        $admin = Admin::findOrFail($id);

        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully');
    }
}
