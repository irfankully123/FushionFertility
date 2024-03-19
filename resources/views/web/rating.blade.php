@auth()
    @if(Auth::user()->hasRole('patient') && Auth::user()->patient)
        @if(\App\Models\SessionRating::where('patient_id', Auth::user()->patient->id)->exists())
            @php
                $sessionRating = \App\Models\SessionRating::where('patient_id', Auth::user()->patient->id)->first();
                $profile='storage/users/'.$sessionRating->doctor->user->profile;
            @endphp

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: '{{$sessionRating->doctor->user->name}}',
                        html: `
                            <div>
                              <img src="{{ asset($profile) }}" alt="Doctor Profile" width="200" height="200">
                              <p class="mt-1">Please rate the doctor.</p>
                              <div id="rating-stars">
                                <i class="far fa-star" data-rating="1"></i>
                                <i class="far fa-star" data-rating="2"></i>
                                <i class="far fa-star" data-rating="3"></i>
                                <i class="far fa-star" data-rating="4"></i>
                                <i class="far fa-star" data-rating="5"></i>
                              </div>
                               <textarea id="feedback" class="form-control mt-3" placeholder="Enter your feedback here..." rows="4" cols="40"></textarea>
                            </div>
                          `,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Submit Feedback',
                        cancelButtonText: 'Cancel',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            const ratingStars = document.querySelectorAll('#rating-stars .fa-star');
                            ratingStars.forEach((star) => {
                                star.addEventListener('click', () => {
                                    const rating = parseInt(star.getAttribute('data-rating'));
                                    ratingStars.forEach((s) => {
                                        if (parseInt(s.getAttribute('data-rating')) <= rating) {
                                            s.classList.add('fas');
                                        } else {
                                            s.classList.remove('fas');
                                        }
                                    });
                                });
                            });
                        },
                        preConfirm: () => {
                            const selectedRating = Array.from(document.querySelectorAll('#rating-stars .fa-star.fas'));
                            if (selectedRating.length === 0) {
                                Swal.showValidationMessage('Please select a rating.');
                                return false;
                            } else {
                                const rating = selectedRating[selectedRating.length - 1].getAttribute('data-rating');
                                const feedback = document.querySelector('#feedback').value;

                                // Validate the text input
                                if (feedback.trim().length === 0) {
                                    Swal.showValidationMessage('Please enter your feedback.');
                                    return false;
                                }

                                return {rating: rating, feedback: feedback};
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const ratingValue = result.value.rating;
                            const feedbackValue = result.value.feedback;

                            fetch('{{  route('doctor.rating.store',$sessionRating)  }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({rating: ratingValue,feedback :feedbackValue})
                            })
                                .then(response => response.json())
                                .then(data => {
                                    // Handle the AJAX response
                                    console.log(data);
                                })
                                .catch(error => {
                                    // Handle any errors
                                    console.log(error);
                                });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            fetch('{{  route('doctor.rating.cancel',$sessionRating)  }}', {
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            })
                                .then(response => response.json())
                                .then(data => {
                                    // Handle the AJAX response
                                    console.log(data);
                                })
                                .catch(error => {
                                    // Handle any errors
                                    console.log(error);
                                });
                        }
                    });
                });
            </script>
        @endif
    @endif
@endauth
