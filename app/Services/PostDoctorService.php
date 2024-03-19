<?php

namespace App\Services;


use App\Http\Requests\PostDoctorRequest;
use App\Models\ZoomAccess;
use Exception;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PostDoctorService
{

    private array $userData;
    private array $userExperience;
    private array $schedules;
    private array $tags;
    private ?UploadedFile $profile;
    private array $zoom;


    public function __construct(PostDoctorRequest $request)
    {
        $this->userData = $request->input('userData');
        $this->userExperience = $request->input('userExperience');
        $this->schedules = $request->input('schedule');
        $this->tags = $request->input('tags');
        $this->profile = $request->file('profile');
        $this->zoom = $request->input('zoom');
    }


    /**
     * @throws Exception
     */
    private function storeAsUser(): User|null
    {
        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $this->userData['name'],
                'email' => $this->userData['email'],
                'user_type' => 'doctor',
                'email_verified_at' => now(),
                'password' => Hash::make($this->userData['password'])
            ]);
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
        return null;
    }


    /**
     * @throws Exception
     */
    private function storeAsDoctor(User $user): Doctor|null
    {
        DB::beginTransaction();
        try {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'gender' => $this->userData['gender'],
                'description' => $this->userExperience['description'],
                'qualification' => $this->userExperience['qualification'],
                'experience' => $this->userExperience['experience'],
                'fee' => $this->userData['fee'],
                'consultant_meeting_time' => $this->userData['consultant_meeting_time'],
                'dob' => $this->userData['dob'],
                'address' => $this->userData['address'],
                'contact' => $this->userData['contact']
            ]);
            DB::commit();
            return $doctor;
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
        return null;

    }

    /**
     * @throws Exception
     */
    private function storeAsSchedule(Doctor $doctor): void
    {
        DB::beginTransaction();
        try {
            if (!empty($this->schedules) && !empty($doctor)) {
                foreach ($this->schedules as $schedule) {
                    if (!empty($schedule['time_from'] && !empty($schedule['time_to']))) {

                        Schedule::create([
                            'doctor_id' => $doctor->id,
                            'day' => $schedule['day'],
                            'time_from' => $schedule['time_from'],
                            'time_to' => $schedule['time_to'],
                        ]);
                    }
                }
                DB::commit();
            }
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
    private function storeAsSpeciality(Doctor $doctor): void
    {
        DB::beginTransaction();
        try {
            if (!empty($this->tags) && !empty($doctor)) {
                foreach ($this->tags as $tag) {
                    Speciality::create([
                        'doctor_id' => $doctor->id,
                        'name' => $tag
                    ]);
                }
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
    private function storeAsProfile(User $user): void
    {
        DB::beginTransaction();
        try {
            if (!empty($this->profile)) {
                $path = Storage::disk('users')->put($user->id, $this->profile);
                $user->forceFill([
                    'profile' => $path
                ])->save();
                DB::commit();
            }
        } catch (Exception $exception) {
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }

    /**
     * @throws Exception
     */
    private function storeAsZoomAccess(Doctor $doctor): void
    {
        try {
            ZoomAccess::create([
                'doctor_id' => $doctor->id,
                'account_id' => $this->zoom['account_id'],
                'client_id' => $this->zoom['client_id'],
                'client_secret' => $this->zoom['client_secret']
            ]);
        } catch (Exception $exception) {
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function createDoctor(): void
    {
        $user = $this->storeAsUser();
        $user->assignRole('doctor');
        $this->storeAsProfile($user);
        $doctor = $this->storeAsDoctor($user);
        if (!$doctor) {
            throw new NotFoundHttpException();
        }
        $this->storeAsSchedule($doctor);
        $this->storeAsSpeciality($doctor);
        $this->storeAsZoomAccess($doctor);
    }


}
