@extends('web.Layout.layout')
@section('title'){{ _('Fusion - Doctor Overview') }}@endsection
@section('content')
<!-- Page Content -->
<div class="content">
    <div class="container">

        <!-- Doctor Widget -->
        <div class="card">
            <div class="card-body">
                <div class="doctor-widget">
                    <div class="doc-info-left">
                        <div class="doctor-img">
                   @if($doctor->user()->first()->profile !== null)
                     <img src="{{ asset('/storage/users/'. $doctor->user()->first()->profile ) }}" class="img-fluid" alt="User Image">
                     @else
                  <img src="{{ asset('placeholder.png') }}" class="img-fluid" alt="Placeholder Image">
                    @endif

                        </div>
                        <div class="doc-info-cont">
                            <h4 class="doc-name">{{ $doctor->user()->first()->name }}</h4>
                            <p class="doc-speciality">{{ $doctor->qualification }}</p>
                            <div class="rating">
                                        @if($rating === 0)
                                           <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                                        @endif  
                                        @if($rating ==='1')
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                                        @endif
                                        @if($rating ==='2')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                                        @endif
                                        @if($rating ==='3')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                                        @if($rating ==='4')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                                        @if($rating ==='5')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                        @endif
                                        <span class="d-inline-block average-rating">({{ $ratingCount }})</span>
                                    </div>
                            <div class="clinic-details">
                                <p class="doc-location"><i class="fas fa-map-marker-alt"></i> {{ $doctor->address }}</p>
                            </div>
                            <div class="clinic-services">
                                @foreach($doctor->specialities()->get() as $speciality)
                                    <span>{{ $speciality->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="doc-info-right">
                        <div class="clini-infos">
                            <ul>
                                  
                                <li><i class="far fa-money-bill-alt"></i>Doctor Fee: ${{ $doctor->fee }} </li>
                            </ul>
                        </div>
                    
                        <div class="clinic-booking">
                            <a class="apt-btn" href="{{ route('appointment.booking', $doctor->id) }}">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Doctor Widget -->

        <!-- Doctor Details Tab -->
        <div class="card">
            <div class="card-body pt-0">

                <!-- Tab Menu -->
                <nav class="user-tabs mb-4">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#doc_business_hours" data-toggle="tab">Business Hours</a>
                        </li>
                    </ul>
                </nav>
                <!-- /Tab Menu -->

                <!-- Tab Content -->
                <div class="tab-content pt-0">

                    <!-- Overview Content -->
                    <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12 col-lg-9">

                                <!-- About Details -->
                                <div class="widget about-widget">
                                    <h4 class="widget-title">About Me</h4>
                                    <p>{{ $doctor->description }}</p>
                                </div>
                                <!-- /About Details -->

                                <!-- Education Details -->
                                <div class="widget education-widget">
                                    <h4 class="widget-title">Qualifications</h4>
                                    <div class="experience-box">
                                        <p>{{ $doctor->qualification }}</p>
                                    </div>
                                </div>
                                <!-- /Education Details -->

                                <!-- Experience Details -->
                                <div class="widget experience-widget">
                                    <h4 class="widget-title">Working Experience</h4>
                                    <div class="experience-box">
                                        <p>{{$doctor->experience}}</p>
                                    </div>
                                </div>
                                <!-- /Experience Details -->

                                <!-- Specializations List -->
                                <div class="service-list">
                                    <h4>Specializations</h4>
                                    <ul class="clearfix">
                                        @foreach($doctor->specialities()->get() as $speciality)
                                        <li>{{ $speciality->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- /Specializations List -->

                            </div>
                        </div>
                    </div>
                    <!-- /Overview Content -->


                    <!-- Business Hours Content -->
                    <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">

                                <!-- Business Hours Widget -->
                                <div class="widget business-widget">
                                    <div class="widget-content">
                                        <div class="listing-hours">
                                            @php
                                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                            @endphp
                                            @foreach($days as $day)
                                                @php
                                                    $schedule = $doctor->schedules()->where('day', $day)->first();
                                                @endphp
                                                <div class="listing-day">
                                                    <div class="day">
                                                        {{ $day }}
                                                    </div>
                                                    <div class="time-items">
                                                        @if($schedule && $schedule->time_from && $schedule->time_to)
                                                            <span class="time">
                                                                {{ date('h:i A', strtotime($schedule->time_from)) }} - {{ date('h:i A', strtotime($schedule->time_to)) }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger text-light">Not Available</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <!-- /Business Hours Widget -->

                            </div>
                        </div>
                    </div>
                    <!-- /Business Hours Content -->

                </div>
            </div>
        </div>
        <!-- /Doctor Details Tab -->

    </div>
</div>
<!-- /Page Content -->

@endsection

@section('condition')
    @php $preloader = true; @endphp
@endsection
