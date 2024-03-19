@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Patient Dashboard') }}
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3">
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    @if(Auth::user()->profile !== null)
                                        <img src="{{ asset('/storage/users/'. Auth::user()->profile) }}" alt="User Image">
                                    @else
                                        <img src="{{ asset('placeholder.png') }}" alt="User Image">
                                    @endif
                                </a>
                                <div class="profile-det-info">
                                    <h3>{{ Auth::user()->name }}</h3>
                                    <div class="patient-details">
                                        @if( Auth::user()->patient()->first()->dob !== null)
                                            <h5><i class="fas fa-birthday-cake"></i> {{ Auth::user()->patient()->first()->dob }}, {{ Auth::user()->patient()->first()->age }} years</h5>
                                        @endif
                                        @if( Auth::user()->patient()->first()->address !== null)
                                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> {{ Auth::user()->patient()->first()->address }}</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                                        <a href="{{ route('patient.dashboard', Auth::user()->id) }}">
                                            <i class="fas fa-columns"></i>
                                            <span>Appointments</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('patient.dashboard.schedule.appointments') ? 'active' : '' }}">
                                        <a href="{{ route('patient.dashboard.schedule.appointments', Auth::user()->id) }}">
                                            <i class="fas fa-calendar"></i>
                                            <span>Schedule Appointments</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('patient.dashboard.appointmentHistory') ? 'active' : '' }}">
                                        <a href="{{ route('patient.dashboard.appointmentHistory', Auth::user()->id) }}">
                                            <i class="fas fa-history"></i>
                                            <span>Appointments History</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('patient.dashboard.profile') ? 'active' : '' }}">
                                        <a href="{{ route('patient.dashboard.profile', Auth::user()->id) }}">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body pt-0">
                            @yield('body')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('condition')
    @php $preloader = false; @endphp
@endsection
