@extends('web.Pages.patient_dashboard_layout')
@section('body')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-main">
        <div class="card-table">
            <div class="table-responsive table-wrapper p-4">
                <table class="table table-center mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Appointment Date</th>
                        <th>Appointment Day</th>
                        <th>Appointment Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <h2 class="table-avatar">
                                    <a href="{{ route('doctor.overview', $appointment->doctor->id) }}"
                                       class="avatar avatar-sm mr-2">
                                        <img class="avatar-img rounded-circle"
                                             src="{{ asset('storage/users/' . $appointment->doctor->user->profile) }}"
                                             alt="User Image">
                                    </a>
                                    <a href="{{ route('doctor.overview', $appointment->doctor->id) }}">{{ $appointment->doctor->user->name }}</a>
                                </h2>
                            </td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td><span class="badge rounded-pill bg-secondary text-light">{{ $appointment->day }}</span>
                            </td>
                            <td><span class="d-block text-info">
                                        {{ date('h:i A', strtotime($appointment->appointment_time)) }} </span>
                            </td>
                            <td>${{ $appointment->amount }}</td>
                            <td>
                                <span class="badge badge-pill bg-success-light">Completed</span>
                            </td>
                            <td>
                                @if(!empty($appointment->doctor_prescription->pdf_url))
                                <a href="{{ asset('storage/doctor/'. $appointment->doctor_prescription->pdf_url) }}" class="w-100 btn btn-sm btn-info" download><i class="fa fa-download" aria-hidden="true"></i> Download Prescription</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $appointments->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
