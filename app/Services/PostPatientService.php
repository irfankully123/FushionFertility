<?php

namespace App\Services;

use App\Http\Requests\PostPatientRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class PostPatientService
{

    private PostPatientRequest $request;


    public function __construct(PostPatientRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function storeAsUser(): User|bool
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $this->request->input('name'),
                'email' => $this->request->input('email'),
                'user_type' => 'patient',
                'email_verified_at' => now(),
                'password' => Hash::make($this->request->input('password'))
            ]);
            $user->assignRole('patient');
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
            return 0;
        }
    }

    /**
     * @throws Exception
     */
    private function storeAsProfile(User $user): void
    {
        DB::beginTransaction();
        try {
            if ($this->request->file('profile') !== null) {
                $path = Storage::disk('users')->put($user->id, $this->request->file('profile'));
                $user->forceFill([
                    'profile' => $path
                ])->save();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function storeAsPatient(User $user): void
    {
        DB::beginTransaction();
        try {
            $user->patient()->create($this->request->only([
                'blood_group',
                'gender',
                'address',
                'zip_code',
                'contact',
                'dob',
                'age',
                'city',
                'state',
                'primary_care_physician',
                'medical_history',
                'current_medications'
            ]));
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }


    /**
     * @throws Exception
     */
    public function createPatient(): void
    {
        $user = $this->storeAsUser();
        $this->storeAsPatient($user);
        $this->storeAsProfile($user);
    }


}
