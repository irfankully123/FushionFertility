@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Doctors') }}
@endsection
@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Meet Our Expert Doctors</span>
                    <h1 class="text-capitalize mb-5 text-lg">Book an Appointment with Our Skilled Medical Professionals</h1>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="content mb-5">
        <div class="container-fluid">
            <div>
                <div class="row">
                    <div class="col-md-12 col-lg-4 col-xl-3">
                        <div class="card search-filter">
                            <div class="card-header">
                                <h3 class="card-title mb-0" style="font-weight: 600;">Search Filter</h3>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{route('doctors.listing')}}">
                                    <div class="filter-widget">
                                        <h4>Search</h4>
                                        <input type="text" class="form-control" placeholder="Search... (e.g: child specialist)" name="search"  value="{{ old('search', request('search')) }}">
                                    </div>
                                    <div class="filter-widget">
                                        <h4>Gender</h4>
                                        <div>
                                            <label class="custom_check">
                                                <input type="checkbox" name="male" {{ old('male', request('male')) ? 'checked' : '' }}>
                                                <span class="checkmark"></span> Male Doctor
                                            </label>
                                        </div>
                                        <div>
                                            <label class="custom_check">
                                                <input type="checkbox" name="female" {{ old('female', request('female')) ? 'checked' : '' }}>
                                                <span class="checkmark"></span> Female Doctor
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-widget">
                                        <h4>Days by</h4>
                                        <select name="days" class="form-control">
                                            <option class="days" value="0">Search by days</option>
                                            <option class="days" value="Monday" {{ old('days', request('days')) == 'Monday' ? 'selected' : '' }}>Monday</option>
                                            <option class="days" value="Tuesday" {{ old('days', request('days')) == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                            <option class="days" value="Wednesday" {{ old('days', request('days')) == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                            <option class="days" value="Thursday" {{ old('days', request('days')) == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                            <option class="days" value="Friday" {{ old('days', request('days')) == 'Friday' ? 'selected' : '' }}>Friday</option>
                                            <option class="days" value="Saturday" {{ old('days', request('days')) == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                            <option class="days" value="Sunday" {{ old('days', request('days')) == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                        </select>
                                    </div>
                                    <div class="filter-widget">
                                        <h4>Fee Range</h4>
                                       <div class="row">
                                        <div class="col-6">
                                            <label for="price_from">From</label>
                                         
                                    <input type="number" placeholder="$" name="price_from" id="price_from" value="{{ old('price_from', request('price_from')) }}" min="1" class="form-control">
                                        </div>
                                        <div class="col-6 line-div">
                                            <label for="price_to">To</label>
                                            <input type="number" id="price_to"  value="{{ old('price_to', request('price_to')) }}"  name="price_to" placeholder="$" min="1" class="form-control">
                                        </div>
                                       </div>
                                    </div>
                                    <div class="btn-search">
                                        <button type="submit" class="btn btn-block">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8 col-xl-9">
                        @foreach ($doctors as $doctor)
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
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
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a
                                                        href="{{ route('doctor.overview', $doctor->id) }}">{{Str::limit($doctor->user()->first()->name , 20, $end='.')}}</a>
                                                </h4>
                                                <p class="doc-speciality">{{ Str::limit($doctor->qualification, 25, $end='...')  }}</p>
                                                    <div class="rating">
                     @if ($doctor->ratings && $doctor->ratings->isEmpty())
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                    @endif

                   @if ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->avg_rating === '1')
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                                        @endif
                                  @if ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->avg_rating === '2')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                                        @endif
                                       @if ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->avg_rating === '3')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                      @if ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->avg_rating === '4')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                                        @endif
                             @if ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->avg_rating === '5')                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                        @endif
                                        <span class="d-inline-block average-rating">({{ ($doctor->ratings && $doctor->ratings->first() && $doctor->ratings->first()->patient_count !== null) ? $doctor->ratings->first()->patient_count : '0' }})</span>
                                    </div>
                                                <div class="clinic-details">
                                                    <p class="doc-location"><i
                                                            class="fas fa-map-marker-alt"></i> {{Str::limit($doctor->address, 20, $end='..')  }}
                                                    </p>
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
                                                    <li><i class="far fa-money-bill-alt"></i>
                                                        ${{ $doctor->fee }} <i
                                                            class="fas fa-info-circle" data-toggle="tooltip"
                                                            title="Appointment-fee"></i></li>
                                                </ul>
                                            </div>
                                            <div class="clinic-booking">
                                                <a class="view-pro-btn"
                                                   href="{{ route('doctor.overview',$doctor->id) }}">View
                                                    Profile</a>
                                                @auth()
                                                    @if (Auth::user()->hasRole('patient'))
                                                        <a href="{{route('appointment.booking',$doctor->id)}}"
                                                           class="apt-btn">Book Now</a>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $doctors->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('condition')
    @php $preloader = true; @endphp
@endsection
