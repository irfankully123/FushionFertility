@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Home') }}
@endsection
@section('content')

    <!-- Home Banner -->
    <section class="section section-search">
        <div class="container-fluid">
            <div class="banner-wrapper">
                <div class="banner-header text-center">
                    <h1 id="hero-heading"></h1>
                    <p id="hero-paragraph"></p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container-fluid shadow-lg" style="height: 50%;">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="section-header py-5 text-center">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                        <h2 id="about-heading" class="mb-5" style="font-weight: 600;"></h2>
                        <p id="about-paragraph" class="sub-title"></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <img src="{{ asset('web/assets/img/vector.jpg') }}" class="img-fluid vector" alt="Vector">
                </div>
            </div>
        </div>
    </section>
    <section class="section section-doctor">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-header">
                        <h2 id="doctors-heading"></h2>
                    </div>
                    <div class="about-content">
                        <p id="doctors-paragraph"></p>
                        <a href="{{ route('doctors.listing')}}">Discover More Doctors</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="doctor-slider slider">

                        @foreach($doctors as $doctor)
                            <!-- Doctor Widget -->
                            <div class="profile-widget">
                                <div class="doc-img">
                                    <a href="{{ route('doctor.overview', $doctor->id) }}">
                                        @if($doctor->user()->first()->profile !== null)
                                            <img class="img-fluid" alt="User Image"
                                                 src="{{ asset('storage/users/'. $doctor->user()->first()->profile) }}">
                                        @else
                                            <img class="img-fluid" alt="User Image"
                                                 src="{{ asset('placeholder.png') }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <h3 class="title">
                                        <a href="{{ route('doctor.overview', $doctor->id) }}">{{Str::limit($doctor->user()->first()->name , 20, $end='.')}}</a>
                                        <i class="fas fa-check-circle verified"></i>
                                    </h3>
                                    <p class="speciality">{{ Str::limit($doctor->qualification, 20, $end='...')  }}</p>
                                    <div class="rating">
                                        @if($doctor->avg_rating === null)
                                           <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                                        @endif
                                        @if($doctor->avg_rating==='1')
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                                        @endif
                                        @if($doctor->avg_rating==='2')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                                        @endif
                                        @if($doctor->avg_rating==='3')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                                        @if($doctor->avg_rating==='4')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                                        @if($doctor->avg_rating==='5')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                                 <i class="fas fa-star filled"></i>
                     
                                        @endif
                                        <span class="d-inline-block average-rating">({{ ($doctor->patient_count > 0) ? $doctor->patient_count : '0' }})</span>
                                    </div>
                                    <ul class="available-info">
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i> {{Str::limit($doctor->address, 20, $end='..')  }}
                                        </li>
                                        <li>
                                            <i class="far fa-clock"></i> Available
                                            @if ($doctor->schedules()->count() > 0)
                                                {{ date('h:i A', strtotime($doctor->schedules()->first()->time_from)) }}
                                                , {{ $doctor->schedules()->first()->day }}
                                            @endif

                                        </li>
                                        <li>
                                            <i class="far fa-money-bill-alt"></i> ${{ $doctor->fee }}
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                               title="Appointment Fee"></i>
                                        </li>
                                    </ul>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <a href="{{ route('doctor.overview',$doctor->id) }}" class="btn view-btn">View
                                                Profile</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('appointment.booking', $doctor->id) }}"
                                               class="btn book-btn">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const timestamp = new Date().getTime(), homeURL = `{{ asset('web_content/home.json') }}?t=${timestamp}`;
        fetch(homeURL).then(e => e.json()).then(e => {
            for (i = 0; i < e.length; i++) "hero" === e[i].section ? (document.getElementById("hero-heading").innerText = e[i].heading, document.getElementById("hero-paragraph").innerText = e[i].paragraph) : "about" === e[i].section ? (document.getElementById("about-heading").innerText = e[i].heading, document.getElementById("about-paragraph").innerText = e[i].paragraph) : "doctors" === e[i].section && (document.getElementById("doctors-heading").innerText = e[i].heading, document.getElementById("doctors-paragraph").innerText = e[i].paragraph)
        });
    </script>

@endsection

@section('condition')
    @php $preloader = true; @endphp
@endsection
