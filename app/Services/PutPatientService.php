<?php

namespace App\Services;


use App\Http\Requests\PutPatientRequest;
use App\Models\Patient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class PutPatientService
{
    private Patient $patient;
    private PutPatientRequest $request;

    public function __construct(Patient $patient, PutPatientRequest $request)
    {
        $this->patient = $patient;
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    private function updateAsUser(): void
    {
        DB::beginTransaction();
        try {
            $this->patient->user()->first()->update([
                'name' => $this->request->input('name'),
                'email' => $this->request->input('email'),
            ]);
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
    private function updateAsPatient(): void
    {
        DB::beginTransaction();
        try {
            $this->patient->update($this->request->only([
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
    private function updatePassword(): void
    {
        DB::beginTransaction();
        try {
            $this->patient->user()->first()->forceFill([
                'password' => Hash::make($this->request->input('password'))
            ])->save();
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
    private function updateAsProfile(): void
    {
        DB::beginTransaction();
        try {
            $user=$this->patient->user()->first();
            $path = Storage::disk('users')->put($user->id, $this->request->file('profile'));
            $user->forceFill([
                'profile' => $path
            ])->save();
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
    public function updatePatient(): void
    {
        $this->updateAsUser();
        $this->updateAsPatient();
        if ($this->request->has('password') && !empty($this->request->input('password'))) {
            $this->updatePassword();
        }
        if ($this->request->hasFile('profile')) {
            $this->updateAsProfile();
        }
    }

}
