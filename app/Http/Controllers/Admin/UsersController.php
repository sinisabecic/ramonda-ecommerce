<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;


class UsersController extends Controller
{
    //? Users page
    // Get users function
    public function index()
    {
        return view('admin.users',
            [
                'users' => User::with('photos')
                    ->where('id', '!=', auth()->id())
                    ->withTrashed()
                    ->get(),
                'countries' => Country::all(),
                'roles' => Role::all()
            ]);
    }

    // Creating a new user
    public function store(Request $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'country_id' => $request->country,
            'address' => $request->address,
        ]);

        if (request()->hasFile('avatar')) {
            $avatar = request()->file('avatar')->getClientOriginalName();
            Storage::putFileAs('files/1/Avatars', request()->file('avatar'), $user->id . '/' . $avatar);
            $user->photo()->create(['url' => $avatar]);
        } else {
            $user->photo()->create(['url' => 'user.jpg']);
        }

        $user->assignRole($request->input('roles')); // can also: $user->assignRoles($request->input('roles', []));

    }

    // Edit single user page
    public function edit($id)
    {
        return view('admin.edit_user', [
            'user' => User::findOrFail($id),
            'countries' => Country::all(),
            'roles' => Role::all(),
        ]);
    }

    // Update user
    public function update(User $user)
    {
        $inputs = request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user), 'regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user)],
            'country_id' => ['string'],
            'address' => ['string'],
        ]);

        $user->update($inputs);

        request()->validate(['role' => 'required|string']);
        $user->syncRoles(request()->input('role'));

        if (request()->get('password')) {
            $user->update(['password' => request()->get('password')]);
        }
        return redirect()->back()->with('success_message', 'User edited.');
    }

    // Async updating avatar
    public function updatePhoto(User $user)
    {
        if (request()->hasFile('avatar')) {
            $file = request()->file('avatar');
            $avatar = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Avatars', request()->file('avatar'), $user->id . '/' . $avatar);
            $user->photo()->update(['url' => $avatar]);
        }
    }

    // View page for making new password
    public function editPassword($id)
    {
        return view('admin.users.edit_password', [
            'user' => User::findOrFail($id)
        ]);
    }


    // Restoring user
    public function restore(User $user, $id)
    {
        $user->whereId($id)->restore();

        return response()->json([
            'message' => 'User restored successfully!'
        ]);
    }

    // Soft delete user
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);
    }

    // Delete user
    public function remove($id)
    {
        User::find($id)->forceDelete();

        return response()->json([
            'message' => 'User deleted forever successfully!',
        ]);
    }

    //! Profile page
//    public function profile(User $user)
//    {
//        return view('admin.users.profile', [
//            'user' => $user,
//            'countries' => Country::all(),
//            'roles' => Role::all(),
//        ]);
//    }

    // Async update new avatar
    public function updateProfilePhoto(User $user)
    {
        if (request()->hasFile('avatar')) {
            $file = request()->file('avatar');
            $avatar = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Avatars', request()->file('avatar'), $user->id . '/' . $avatar);
            $user->photo()->update(['url' => $avatar]);
        }
    }

    // Bulk deleting(soft delete) users
    public function deleteUsers(Request $request)
    {
        $ids = $request->ids;
        User::whereIn("id", explode(",", $ids))->delete();
    }


    // Bulk hard deleting users
    public function removeUsers(Request $request)
    {
        $ids = $request->ids;
        DB::table('users')->whereIn("id", explode(",", $ids))->delete();
    }

    // Bulk restoring users
    public function restoreUsers(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', explode(",", $ids))->restore();
        return response()->json(['success' => "Users restored successfully."]);
    }


    // Update password
    public function updatePassword($id)
    {
        $user = User::whereId($id);

        $inputs = request()->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $inputs['password'] = Hash::make($inputs['password']);
        $user->update($inputs);
    }

    // Profile update
//    public function profileUpdate(User $user)
//    {
//        $inputs = request()->validate([
//            'name' => ['required', 'string', 'max:255'],
//            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user), 'regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
//            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user)],
//            'country_id' => ['string'],
//            'address' => ['string'],
//        ]);
//
//        $user->update($inputs);
//    }

}
