@extends('web.Pages.patient_dashboard_layout')
@section('body')
    <div class="row">
        <div class="col-12 p-4">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('patient.dashboard.update',Auth::user()->id) }}"
                          enctype="multipart/form-data" id="patientForm">
                        @csrf
                        @method('PUT')
                        <div class="row form-row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <div class="change-avatar">
                                        <div class="profile-img">
                                            @if($patient->user()->first()->profile !== null)
                                                <img id="preview"
                                                     src="{{ asset('/storage/users/'. $patient->user()->first()->profile) }}"
                                                     alt="User Image">
                                            @else
                                                <img id="preview" src="{{ asset('placeholder.png') }}" alt="User Image">
                                            @endif
                                        </div>
                                        <div class="upload-img">
                                            <div class="change-photo-btn">
                                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                <input type="file" name="profile" id="profile" class="upload">
                                            </div>
                                            <small class="form-text text-muted">Allowed JPG, JPEG or PNG</small>
                                            @error('profile')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob', $patient->dob) }}"
                                           class="form-control">
                                    @error('dob')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select class="form-control" name="blood_group">
                                        <option value="0">Your Blood Group</option>
                                        <option {{ $patient->blood_group === 'A-' ? 'selected' : '' }} value="A-">A-
                                        </option>
                                        <option {{ $patient->blood_group === 'A+' ? 'selected' : '' }} value="A+">A+
                                        </option>
                                        <option {{ $patient->blood_group === 'B-' ? 'selected' : '' }} value="B-">B-
                                        </option>
                                        <option {{ $patient->blood_group === 'B+' ? 'selected' : '' }} value="B+">B+
                                        </option>
                                        <option {{ $patient->blood_group === 'AB-' ? 'selected' : '' }} value="AB-">
                                            AB-
                                        </option>
                                        <option {{ $patient->blood_group === 'AB+' ? 'selected' : '' }} value="AB+">
                                            AB+
                                        </option>
                                        <option {{ $patient->blood_group === 'O-' ? 'selected' : '' }} value="O-">O-
                                        </option>
                                        <option {{ $patient->blood_group === 'O+' ? 'selected' : '' }} value="O+">O+
                                        </option>
                                    </select>
                                    @error('blood_group')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="0">Your Gender</option>
                                        <option {{ $patient->gender === 'M' ? 'selected' : '' }} value="M">Male</option>
                                        <option {{ $patient->gender === 'F' ? 'selected' : '' }}  value="F">Female
                                        </option>
                                    </select>
                                    @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="number" name="contact" class="form-control"
                                           value="{{ old('contact', $patient->contact) }}">
                                    @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ old('address', $patient->address) }}">
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control"
                                           value="{{ old('city', $patient->city) }}">
                                    @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state" class="form-control"
                                           value="{{ old('state', $patient->state) }}">
                                    @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input type="number" name="zip_code" class="form-control"
                                           value="{{ old('zip_code', $patient->zip_code) }}">
                                    @error('zip_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="number" name="age" class="form-control"
                                           value="{{ old('age', $patient->age) }}">
                                    @error('age')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Primary Care Physician</label>
                                    <textarea class="form-control" name="primary_care_physician" cols="4"
                                              rows="3">{{old('primary_care_physician', $patient->primary_care_physician)}}</textarea>
                                    @error('primary_care_physician')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Medical History</label>
                                    <textarea class="form-control" name="medical_history" cols="4"
                                              rows="3">{{old('medical_history', $patient->medical_history)}}</textarea>
                                    @error('medical_history')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Current Medications</label>
                                    <textarea class="form-control" name="current_medications" cols="4"
                                              rows="3">{{old('current_medications', $patient->current_medications)}}</textarea>
                                    @error('current_medications')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="submit-section d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary submit-btn" id="patient-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const uploadInput = document.getElementById('profile');
        const previewImage = document.getElementById('preview');

        uploadInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            let form = document.getElementById('patientForm');
            let PatientBtn = document.getElementById('patient-btn');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                PatientBtn.disabled = true;
                PatientBtn.innerHTML +=
                    '<span class="spinner-border spinner-border-sm" style="margin-bottom:3px; margin-left: 10px;" role="status" aria-hidden="true"></span>';
                form.submit();
            });
        });
    </script>
@endsection
