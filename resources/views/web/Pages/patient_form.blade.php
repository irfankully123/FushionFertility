@extends('web.Layout.layout')
@section('title'){{ _('Fusion - Dashboard') }}@endsection
@section('content')
    <section class="page-title bg-1">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Patient Form</span>
                        <h1 class="text-capitalize mb-5 text-lg">Please Complete Your Form Before Book An Appointment</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('patient.dashboard.store',Auth::user()->id) }}" id="patientForm">
                                @csrf
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth <span class="text-secondary">(optional)</span></label>
                                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                                            @error('dob')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Blood Group <span class="text-secondary">(optional)</span></label>
                                            <select  class="form-control" name="blood_group">
                                                <option value="">Your Blood Group</option>
                                                <option  value="A-">A-</option>
                                                <option  value="A+">A+</option>
                                                <option  value="B-">B-</option>
                                                <option  value="B+">B+</option>
                                                <option  value="AB-">AB-</option>
                                                <option  value="AB+">AB+</option>
                                                <option  value="O-">O-</option>
                                                <option value="O+">O+</option>
                                            </select>
                                            @error('blood_group')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Gender <span class="text-danger">*</span></label>
                                            <select class="form-control" name="gender">
                                                <option  value="0">Your Gender</option>
                                                <option  value="M">Male</option>
                                                <option  value="F">Female</option>
                                            </select>
                                            @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Contact <span class="text-danger">*</span></label>
                                            <input type="number" name="contact" class="form-control" value="{{ old('contact') }}">
                                            @error('contact')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Address <span class="text-secondary">(optional)</span></label>
                                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>City <span class="text-danger">*</span></label>
                                            <input type="text" name="city" class="form-control" value="{{ old('city') }}" >
                                            @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>State <span class="text-secondary">(optional)</span></label>
                                            <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                                            @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Zip Code <span class="text-secondary">(optional)</span></label>
                                            <input type="number" name="zip_code" class="form-control"  value="{{ old('zip_code') }}">
                                            @error('zip_code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Age <span class="text-secondary">(optional)</span></label>
                                            <input type="number" name="age" class="form-control" value="{{ old('age') }}">
                                            @error('age')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label>Primary Care Physician <span class="text-secondary">(optional)</span></label>
                                            <textarea class="form-control" name="primary_care_physician" cols="4" rows="3" >{{old('primary_care_physician')}}</textarea>
                                            @error('primary_care_physician')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label>Medical History <span class="text-secondary">(optional)</span></label>
                                            <textarea class="form-control" name="medical_history" cols="4" rows="3" >{{old('medical_history')}}</textarea>
                                            @error('medical_history')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>   <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label>Current Medications <span class="text-secondary">(optional)</span></label>
                                            <textarea class="form-control" name="current_medications" cols="4" rows="3">{{old('current_medications')}}</textarea>
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
        </div>
    </div>

    <script>
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
@section('condition')
    @php $preloader = true; @endphp
@endsection

