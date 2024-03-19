@extends('web.Pages.patient_dashboard_layout')
@section('body')
    @if (session('success'))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ session('success') }}</strong> "Please note that your Zoom URL will be sent to you at the
            scheduled
            time and date of your appointment. Make sure to check your inbox for the email containing the Zoom URL. If
            you
            have any questions or concerns, please don't hesitate to reach out to us."
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
                            <td><span
                                    class="d-block text-info">{{ date('h:i A', strtotime($appointment->appointment_time)) }} </span>
                            </td>
                            <td>${{ $appointment->amount }}</td>
                            <td>
                                <span class="badge badge-pill {{ ($appointment->status === 'Paid') ? 'bg-primary-light' : 'bg-info-light' }}">{{$appointment->status}}</span>
                            </td>
                            <td class="text-right">
                           <div class="col-6">
    @php
        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d');
        $appointmentTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i:s');
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
        $currentTime = \Carbon\Carbon::now()->format('H:i:s');
    @endphp
    @if ($appointmentDate <= $currentDate && $appointment->status === 'Meeting')
        <button class="btn btn-sm btn-info joinMeetingButtons" onclick="redirectToZoom('{{ $appointment->zoom_join_url }}')">
            Join Meeting
        </button>
    @else
        <button class="btn btn-sm btn-info zoom-btn" disabled>
            Join Meeting
        </button>
    @endif
</div>

                                <script>
                                    function redirectToZoom(url) {
                                        window.location.href = url;
                                    }
                                </script>
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
