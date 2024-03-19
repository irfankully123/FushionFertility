@extends('web.Pages.patient_dashboard_layout')
@section('body')
    @if (session('error'))
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ session('error') }}</strong> Your Payment has been canceled
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
                        <th>actions</th>
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
                                        @if ($appointment->doctor->user->profile !== null)
                                            <img
                                                src="{{ asset('/storage/users/' . $appointment->doctor->user->profile) }}"
                                                class="avatar-img rounded-circle" alt="User Image">
                                        @else
                                            <img src="{{ asset('placeholder.png') }}" alt="Placeholder Image">
                                        @endif

                                    </a>
                                    <a
                                        href="{{ route('doctor.overview', $appointment->doctor->id) }}">{{ $appointment->doctor->user->name }}</a>
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
                                <span class="badge badge-pill bg-warning-light">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="row pl-3">
                                    <form method="POST" action="{{ route('appointment.checkout', $appointment->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm bg-primary-light mx-1">
                                            <i class="fa fa-id-card" aria-hidden="true"></i> Checkout
                                        </button>
                                    </form>
                                    <form method="GET" action="{{ route('patient.appointment.destroy', $appointment->id) }}">
                                        <button type="submit" class="btn btn-sm bg-danger-light mx-1">
                                            <i class="fa fa-ban" aria-hidden="true"></i> Cancel
                                        </button>
                                    </form>
                                </div>
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
