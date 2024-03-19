@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Patient Form') }}
@endsection
@section('content')
    <style>
    .custom-file-input:lang(en)~.custom-file-label::after{content:'Browse'}.custom-file-input-selected:lang(en)~.custom-file-label::after{content:attr(data-selected)}#main{margin:50px 0}#main #faq .card{margin-bottom:30px;border:0}#main #faq .card .card-header{border:0;-webkit-box-shadow:0 0 20px 0 rgba(213,213,213,.5);box-shadow:0 0 20px 0 rgba(213,213,213,.5);border-radius:2px;padding:0}#main #faq .card .card-header .btn-header-link{display:block;text-align:left;color:#222;padding:20px}#main #faq .card .card-header .btn-header-link:after{content:"\f107";font-family:'Font Awesome 5 Free';font-weight:900;float:right}#main #faq .card .card-header .btn-header-link.collapsed{color:#000}#main #faq .card .card-header .btn-header-link.collapsed:after{content:"\f106"}#main #faq .card .collapsing{line-height:30px}#main #faq .card .collapse{border:0}#main #faq .card .collapse.show{line-height:30px;color:#222}
    </style>
    
    <section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Book an Appointment with {{ $doctor->user()->first()->name }}</span>
                    <h1 class="text-capitalize mb-5 text-lg">Consult Our Specialist Doctor</h1>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="content">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="booking-doc-info">
                                <a href="doctor-profile.html" class="booking-doc-img">
                                    <img src="{{ asset('/storage/users/' . $doctor->user()->first()->profile) }}"
                                         alt="User Image">
                                </a>
                                <div class="booking-info">
                                    <h4><a
                                            href="{{ route('doctor.overview', $doctor->id) }}">{{ $doctor->user()->first()->name }}</a>
                                    </h4>
                                    <div class="rating">
                                        @if($ratingValue === 0)
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @endif
                                        @if($ratingValue ==='1')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @endif
                                        @if($ratingValue ==='2')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @endif
                                        @if($ratingValue ==='3')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @endif
                                        @if($ratingValue ==='4')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                        @endif
                                        @if($ratingValue ==='5')
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                        @endif
                                        <span class="d-inline-block average-rating">({{ $ratingCount }})</span>
                                    </div>
                                    <p class="text-muted mb-0"><i
                                            class="fas fa-map-marker-alt"></i> {{ $doctor->address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="h3">Appointment Timings</p>
                    <form method="post" enctype="multipart/form-data"
                          action="{{ route('appointment.booking.post', $doctor->id) }}" id="appointmentForm">
                        @csrf
                        <div class="card booking-schedule schedule-widget" style="max-height:400px; overflow-y:auto;">
                            <div class="schedule-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="day-slot">
                                            <ul>
                                                <li>
                                                    <span>Mon</span>
                                                    <span class="date" id="monday"></span>
                                                </li>
                                                <li>
                                                    <span>Tue</span>
                                                    <span id="tuesday" class="date"></span>
                                                </li>
                                                <li>
                                                    <span>Wed</span>
                                                    <span id="wednesday" class="date"></span>
                                                </li>
                                                <li>
                                                    <span>Thu</span>
                                                    <span id="thursday" class="date"></span>
                                                </li>
                                                <li>
                                                    <span>Fri</span>
                                                    <span id="friday" class="date"></span>
                                                </li>
                                                <li>
                                                    <span>Sat</span>
                                                    <span id="saturday" class="date"></span>
                                                </li>
                                                <li>
                                                    <span>Sun</span>
                                                    <span id="sunday" class="date"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="schedule-cont">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="time-slot">
                                            <input name="appointment_time" type="hidden" id="timeValue"/>
                                            <input name="appointment_date" type="hidden" id="dateValue"/>
                                            <input name="day" type="hidden" id="day">
                                            <ul class="clearfix">
                                                <li id="Monday">
                                                    <input type="hidden" class="dayValue" value="Monday">
                                                    <input type="hidden" id="monDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Monday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Monday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>
                                                <li id="Tuesday">
                                                    <input type="hidden" class="dayValue" value="Tuesday">
                                                    <input type="hidden" id="tueDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Tuesday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Tuesday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>
                                                <li id="Wednesday">
                                                    <input type="hidden" class="dayValue" value="Wednesday">
                                                    <input type="hidden" id="wedDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Wednesday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Wednesday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>

                                                <li id="Thursday">
                                                    <input type="hidden" class="dayValue" value="Thursday">
                                                    <input type="hidden" id="thuDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Thursday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Thursday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>
                                                <li id="Friday">
                                                    <input type="hidden" class="dayValue" value="Friday">
                                                    <input type="hidden" id="friDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Friday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Friday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>
                                                <li id="Saturday">
                                                    <input type="hidden" class="dayValue" value="Saturday">
                                                    <input type="hidden" id="satDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Saturday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Saturday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>

                                                <li id="Sunday">
                                                    <input type="hidden" class="dayValue" value="Sunday">
                                                    <input type="hidden" id="sunDate" class="dateValue" value="">
                                                    @foreach ($timeSlots['Sunday'] as $time)
                                                        <button type="button" class="timing w-100">
                                                            <span>{{ $time }}</span>
                                                        </button>
                                                    @endforeach

                                                    @empty($timeSlots['Sunday'])
                                                        <span class="badge bg-warning text-light w-100">Closed</span>
                                                    @endempty
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                        <p class="h3">Appointment Reason</p>
                        <div class="card booking-schedule schedule-widget">
                            <textarea name="appointment_reason" class="form-control border-primary" placeholder="Describe your appointment reason!" cols="4"
                                      rows="6">{{ old('appointment_reason') }}</textarea>
                        </div>
                      </div>
                    </div>
                     
                             <div id="main">

                          <div class="accordion" id="faq">

                    <div class="card">
                        <div class="card-header" id="faqhead3">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3"
                            aria-expanded="true" aria-controls="faq3"><p class="h4 m-0 p-0 d-inline">Attach Prescription</p></a>
                        </div>

                        <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                            <div class="card-body">
                                 <p class="h3">Doctor's Prescription</p>

                        <div class="card">

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group p-4">
                                        <label class="form-label">Attach Image <span
                                                class="text-secondary">(optional)</span></label>
                                        <div class="custom-file">
                                            <input name="prescriptionImage" type="file" class="custom-file-input"
                                                   id="customFile" onchange="updateFileName(this)">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group p-4">
                                        <label class="form-label">Attach Pdf <span
                                                class="text-secondary">(optional)</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="prescriptionPdf" class="custom-file-input"
                                                   id="customPdf" onchange="updatePdfName(this)">
                                            <label class="custom-file-label" for="customPdf">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group p-4">
                                        <label class="form-label" for="prescription-description">Description <span
                                                class="text-secondary">(optional)</span></label>
                                        <textarea name="prescriptionDescription" id="prescription-description" cols="30"
                                                  rows="5"
                                                  class="form-control border-primary">{{ old('prescriptionDescription') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
                        <div class="submit-section proceed-btn text-right">
                            <button type="submit" class="btn btn-primary submit-btn" id="book-appointment-btn">Book
                                Appointment
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <style>
        .disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .highlighted {
            background-color: yellow;
        }
    </style>



    <script>

        let today = new Date();
        let dates = [];

        let daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        const dayMap = {
            Monday: 'monDate',
            Tuesday: 'tueDate',
            Wednesday: 'wedDate',
            Thursday: 'thuDate',
            Friday: 'friDate',
            Saturday: 'satDate',
            Sunday: 'sunDate'
        };

        for (let i = 0; i < 7; i++) {
            let day = daysOfWeek[today.getDay()];
            let date = today.toLocaleDateString();
            dates.push({
                day: day,
                date: date
            });
            today.setDate(today.getDate() + 1);
        }
        dates.forEach(function (item) {
            let day = item.day.toLowerCase();
            document.getElementById(day).textContent = item.date

            if (dayMap.hasOwnProperty(item.day)) {
                const dayId = dayMap[item.day];
                const hiddenDate = document.getElementById(dayId);

                if (hiddenDate) {
                    hiddenDate.value = item.date;
                }
            }
        });

        const hiddenInput = document.getElementById('timeValue');
        const hiddenInputDate = document.getElementById('dateValue');


        const buttonTags = document.querySelectorAll('button.timing');
        buttonTags.forEach(buttonTag => {
            buttonTag.addEventListener('click', function () {
                buttonTags.forEach(tag => {
                    tag.classList.remove('selected');
                });
                this.classList.add('selected');
                hiddenInput.value = this.querySelector('span:first-child').innerHTML.trim();
            });
        });

        const buttons = document.querySelectorAll('li button.timing');
        const hiddenInputDay = document.getElementById('day');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const parentLi = this.closest('li');
                const dayValueInput = parentLi.querySelector('input.dayValue');
                const dateValueInput = parentLi.querySelector('input.dateValue');
                hiddenInputDay.value = dayValueInput.value;
                hiddenInputDate.value = dateValueInput.value;
            });
        });

        let appointments = {!! json_encode($appointments) !!};
        appointments.forEach(function (appointment) {
            let appointmentTime = appointment.appointment_time;
            let appointmentDate = appointment.appointment_date;
            let buttons = document.querySelectorAll('.timing');
            buttons.forEach(function (button) {
                let buttonTime = button.querySelector('span:first-child').innerText.trim();
                let buttonDateInput = button.parentElement.querySelector('.dateValue');
                let buttonDate = buttonDateInput.value;
                // Convert button time to the desired format (1:00 AM/PM)
                let formattedButtonTime = formatTime(buttonTime);
                // Convert appointment date to the desired format (MM/DD/YYYY)
                let formattedAppointmentDate = formatDate(appointmentDate);

                if (formattedButtonTime === appointmentTime && buttonDate === formattedAppointmentDate) {

                    let anchorTag = document.createElement('a');
                    anchorTag.href = '#';
                    anchorTag.classList.add('disabled');
                    anchorTag.classList.add('timing');
                    anchorTag.innerHTML = button.innerHTML;
                    button.parentNode.replaceChild(anchorTag, button);
                }
            });
        });

        function formatTime(time) {
            // Remove leading zero from the hour if present
            if (time.startsWith('0')) {
                time = time.substring(1);
            }
            return time;
        }

        // Function to format the appointment date to MM/DD/YYYY
        function formatDate(dateString) {
            let dateParts = dateString.split('/');
            let month = dateParts[0];
            let day = dateParts[1];
            let year = dateParts[2];
            return month + '/' + day + '/' + year;
        }

        const currentDate = new Date();
        const currentTime = currentDate.getHours() * 60 + currentDate.getMinutes(); // Convert time to minutes for comparison

        function getCurrentDate() {
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString();
            return month + "/" + day + "/" + year;
        }


        const currentDateStore = getCurrentDate();

        const previousButtons = document.querySelectorAll('button.timing');
        previousButtons.forEach(button => {
            const dateValueInput = button.parentElement.querySelector('.dateValue');
            const buttonDate = dateValueInput.value;

            if (buttonDate === currentDateStore || buttonDate === currentDateStore.replace(/^0/, '')) {
                const buttonTime = button.querySelector('span').innerText.trim();
                const buttonHours = parseInt(buttonTime.split(':')[0]);
                const buttonMinutes = parseInt(buttonTime.split(':')[1].split(' ')[0]); // Extract minutes from HH:MM AM/PM format
                const buttonPeriod = buttonTime.split(' ')[1]; // Extract AM/PM period
                const buttonTotalMinutes = buttonHours % 12 * 60 + buttonMinutes + (buttonPeriod === 'PM' ? 720 : 0); // Convert to 24-hour format for comparison
                // Disable the button if the time has passed
                if (buttonTotalMinutes < currentTime) {

                    const anchorTag = document.createElement('a');
                    anchorTag.href = '#';
                    anchorTag.classList.add('disabled');
                    anchorTag.classList.add('timing');
                    anchorTag.innerHTML = button.innerHTML;

                    button.parentNode.replaceChild(anchorTag, button);
                } else {
                    // Update button time format with minutes and period
                    button.querySelector('span').innerText = buttonHours.toString().padStart(2, '0') + ':' + buttonMinutes
                        .toString().padStart(2, '0') + ' ' + buttonPeriod;
                }
            }
        });

        document.getElementById('appointmentForm').addEventListener('submit', function (event) {
            const selectedButton = document.querySelector('button.selected');
            if (!selectedButton) {
                event.preventDefault();
                alert('Please select a time for your appointment.');
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            let form = document.getElementById('appointmentForm');
            let bookAppointmentBtn = document.getElementById('book-appointment-btn');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                bookAppointmentBtn.disabled = true;
                bookAppointmentBtn.innerHTML +=
                    '<span class="spinner-border spinner-border-sm" style="margin-bottom:3px; margin-left: 10px;" role="status" aria-hidden="true"></span>';
                form.submit();
            });
        });

        function updateFileName(input) {
            let fileName = input.files[0].name;
            let label = input.nextElementSibling;
            label.setAttribute("data-selected", fileName);
            label.innerHTML = fileName;
        }

        function updatePdfName(input) {
            let fileName = input.files[0].name;
            let label = input.nextElementSibling;
            label.setAttribute("data-selected", fileName);
            label.innerHTML = fileName;
        }
        
    </script>

@endsection

@section('condition')
    @php $preloader = true; @endphp
@endsection
