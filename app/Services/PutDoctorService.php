<?php

namespace App\Services;

use App\Http\Requests\PutDoctorRequest;
use App\Models\Doctor;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class PutDoctorService
{

    private Doctor $doctor;
    private array $userData;
    private array $userExperience;
    private array $schedules;
    private array $tags;
    private ? UploadedFile $profile;
    private array $zoom;

    public function __construct(Doctor $doctor, PutDoctorRequest $request)
    {
        $this->doctor = $doctor;
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
    private function UpdateAsUser(): void
    {
        DB::beginTransaction();
        try {
            $this->doctor->user()->first()->update([
                'name' => $this->userData['name'],
                'email' => $this->userData['email'],
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
    private function updateAsDoctor(): void
    {
        DB::beginTransaction();
        try {
            $this->doctor->update([
                'user_id' => $this->doctor->user()->first()->id,
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
    private function updateAsSchedule(): void
    {
        DB::beginTransaction();
        try {
            foreach ($this->schedules as $schedule) {
                if ($schedule['isChecked'] === false) {
                    // Delete the record if both time_from and time_to are empty
                    $existingSchedule = $this->doctor->schedules()->where('day', $schedule['day'])->first();
                    $existingSchedule?->delete();
                } else {

                    $this->doctor->schedules()->updateOrCreate(
                        ['day' => $schedule['day']],
                        [
                            'time_from' => $schedule['time_from'],
                            'time_to' => $schedule['time_to'],
                        ]
                    );
                    DB::commit();
                }
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
    private function updateAsSpeciality(): void
    {
        DB::beginTransaction();
        try {
            if (!empty($this->tags) && !empty($this->doctor)) {

                $existingTags = $this->doctor->specialities()->pluck('name')->toArray();

                // Delete tags that are not in the request
                $tagsToDelete = array_diff($existingTags, $this->tags);
                $this->doctor->specialities()->whereIn('name', $tagsToDelete)->delete();

                // Create new tags
                $tagsToCreate = array_diff($this->tags, $existingTags);

                foreach ($tagsToCreate as $tag) {
                    $this->doctor->specialities()->create([
                        'name' => $tag,
                    ]);
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
    private function updateAsProfile(): void
    {
        DB::beginTransaction();
        try {
            if (!empty($this->profile)) {
                $path = Storage::disk('users')->put($this->doctor->user()->firstOr()->id, $this->profile);
                $this->doctor->user()->firstOr()->update([
                    'profile' => $path
                ]);
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
    private function updateAsPassword(): void
    {
        DB::beginTransaction();
        try {
            $this->doctor->user()->first()->update([
                'password' => Hash::make($this->userData['password'])
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
    private function updateAsZoomAccess(): void
    {
        DB::beginTransaction();
        try {
            $this->doctor->zoomAccess()->first()->forceFill(
                $this->zoom
            )->save();
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
    public function updateDoctor(): void
    {
        $this->UpdateAsUser();
        if (!empty($this->userData['password'])) {
            $this->updateAsPassword();
        }
        $this->updateAsDoctor();
        $this->updateAsSchedule();
        $this->updateAsProfile();
        $this->updateAsSpeciality();
        $this->updateAsZoomAccess();
    }


}
