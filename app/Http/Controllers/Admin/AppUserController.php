<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PutUserRequest;
use App\Http\Requests\Dashboard\StoreUserRequest;
use App\Models\User;
use App\Services\AppUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;


class AppUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super']);
    }

    public function index(): Response
    {
        return Inertia::render('Admin/AppUsers/AppUsersIndex', [
            'users' => User::whereIn('user_type', ['admin'])->get()->toArray(),
            'permissions' => Permission::all()->toArray()
        ]);
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = AppUserService::storeAsUser($request);

        $user->assignRole('admin');

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $path = Storage::disk('users')->put($user->id, $profile);
            $user->forceFill([
                'profile' => $path
            ])->save();
        }

        return to_route('dashboard.user');
    }


    public function update(PutUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $path = Storage::disk('users')->put($user->id, $profile);
            $user->forceFill([
                'profile' => $path
            ])->save();
        }

        return to_route('dashboard.user');
    }


    public function assignPermission(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'permission' => ['required', 'string', Rule::notIn(['0'])],
        ]);

        $user->givePermissionTo($request->input('permission'));

        return to_route('dashboard.user');

    }


    public function revokePermission(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'permission' => ['required', 'string', Rule::notIn(['0'])],
        ]);

        $user->revokePermissionTo($request->input('permission'));

        return to_route('dashboard.user');
    }


    public function userPermissions(User $user): Response
    {
        return Inertia::render('Admin/AppUsers/AppUsersPermissions', [
            'permissions' => $user->permissions()->get()->toArray(),
            'user_name' => $user->name
        ]);
    }


    public function destroy(User $user): void
    {
        $user->delete();
    }

}
