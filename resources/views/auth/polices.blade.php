<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<title>Fusion - Terms & Conditions</title>

		<!-- Favicons -->
		<link type="image/x-icon" href="{{ asset('web/assets/img/favicon.png') }}" rel="icon">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('web/assets/css/bootstrap.min.css') }}">
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('web/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('web/assets/plugins/fontawesome/css/all.min.css') }}">
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('web/assets/css/style.css') }}">

</head>
	<body>

        <!-- Main Wrapper -->
		<div class="main-wrapper">
		    <!-- Header -->
            <header class="header">
                <nav class="navbar navbar-expand-lg header-nav">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="/" class="navbar-brand logo">
                            <img src="{{ asset('web/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="/" class="menu-logo">
                                <img src="{{ asset('web/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home')  }}">Home</a>
                            </li>
                            <li class="{{ request()->routeIs('doctors.listing') ? 'active' : '' }}">
                                <a href="{{ route('doctors.listing') }}">Doctors</a>
                            </li>
                            <li class="{{ request()->routeIs('blogs') ? 'active' : '' }}">
                                <a href="{{ route('blogs') }}">Blogs</a>
                            </li>
                        </ul>
                    </div>

                    <ul class="nav header-navbar-rht">
                    </ul>
                </nav>
            </header>

<div class="container p-5">

    <p class="h1 mb-5">Policies</p>

    <h2>1. Privacy Policy</h2>
    <p>1.1 The privacy policy explains how we collect, use, and protect your personal information when you use the doctor appointment website. Please review our <a href="privacy.html">Privacy Policy</a> for detailed information.</p>

    <h2>2. Cookie Policy</h2>
    <p>2.1 The cookie policy outlines how we use cookies and similar technologies on our website. By using the doctor appointment website, you consent to the use of cookies as described in our <a href="cookies.html">Cookie Policy</a>.</p>

    <h2>3. User Account Policy</h2>
    <p>3.1 The user account policy describes the terms and conditions for creating and managing user accounts on the doctor appointment website. By creating an account, you agree to comply with our <a href="account.html">User Account Policy</a>.</p>

    <h2>4. Doctor Listings Policy</h2>
    <p>4.1 The doctor listings policy outlines the guidelines for doctors to be listed on the doctor appointment website. It includes requirements, verification procedures, and compliance with applicable laws and regulations. Please refer to our <a href="doctor-listings.html">Doctor Listings Policy</a> for more information.</p>

    <h2>5. Appointment Booking Policy</h2>
    <p>5.1 The appointment booking policy explains the terms and conditions for scheduling and managing appointments through the doctor appointment website. By using this service, you agree to adhere to our <a href="appointment-booking.html">Appointment Booking Policy</a>.</p>

    <h2>6. Payment Policy</h2>
    <p>6.1 The payment policy describes the terms and conditions for making payments for services rendered through the doctor appointment website. By using our payment services, you agree to comply with our <a href="payment.html">Payment Policy</a>.</p>

    <h2>7. Dispute Resolution Policy</h2>
    <p>7.1 The dispute resolution policy outlines the procedures and guidelines for resolving disputes that may arise between users and doctors on the doctor appointment website. Please review our <a href="dispute-resolution.html">Dispute Resolution Policy</a> for detailed information.</p>

    <h2>8. Intellectual Property Policy</h2>
    <p>8.1 The intellectual property policy explains the rights and restrictions regarding the use of the doctor appointment website's content, trademarks, and copyrights. Please refer to our <a href="intellectual-property.html">Intellectual Property Policy</a> for more details.</p>

    <h2>9. Termination Policy</h2>
    <p>9.1 The termination policy outlines the circumstances under which we may terminate or suspend user accounts or access to the doctor appointment website. By using the website, you agree to comply with our <a href="termination.html">Termination Policy</a>.</p>

    <h2>10. Modifications to the Policies</h2>
    <p>10.1 We reserve the right to modify these policies at any time without prior notice. Your continued use of the doctor appointment website after any modifications indicates your acceptance of the updated policies.</p>

</div>


<footer class="footer" style="position: relative; bottom: 0;">
    <div class="footer-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget footer-about">
                        <div class="footer-logo">
                            <img src="{{ asset('web/assets/img/fusion-logo.png') }}" alt="logo" width="200">
                        </div>
                        <div class="footer-about-content">
                            <p id="footer-paragraph"></p>
                            <div class="social-icon">
                                <ul id="social-links"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Pages</h2>
                        <ul>
                            <li><a href="{{ route('home') }}"><i class="fas fa-angle-double-right"></i> Home</a></li>
                            <li><a href="{{ route('doctors.listing') }}"><i class="fas fa-angle-double-right"></i> Doctors</a></li>
                            <li><a href="{{ route('blogs') }}"><i class="fas fa-angle-double-right"></i> Blogs</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">For Support</h2>
                        <ul>
                            <li><a href="/terms"><i class="fas fa-angle-double-right"></i> Term & Conditions</a></li>
                            <li><a href="/policies"><i class="fas fa-angle-double-right"></i> Privacy Policies</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact Us</h2>
                        <div class="footer-contact-info">
                            <div class="footer-address">
                                <span><i class="fas fa-map-marker-alt"></i></span>
                                <p id="footer-address"></p>
                            </div>
                            <p id="footer-contact">
                                <i class="fas fa-phone-alt"></i>
                            </p>
                              <a class="text-warning" href="mailto:support@fusionfertility.co.uk"><p id="footer-email" class="mb-0">
                                <i class="fas fa-envelope"></i>
                            </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row">
        <div class="col-12 col-md-6">
              <p class="w-100 p-0 m-0 text-light text-center"><span>&copy; Copyright <script>const date=new Date;let year=date.getFullYear();document.write(year);</script> <a href="/" class="text-primary">Fusion Fertility</a></span></p>
        </div>
        <div class="col-12 col-md-6">
            <p class="text-center p-0 m-0 text-light mt-1">Developed by <a href="https://www.facebook.com/TheWebInnovators?mibextid=ZbWKwL" target="_blank" class="text-primary">Web Innovators</a></p>
        </div>
    </div>
</footer>

        </div>


        <!-- jQuery -->
		<script src="{{ asset('web/assets/js/jquery.min.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/theia-sticky-sidebar@1.7.0/dist/theia-sticky-sidebar.min.js" ></script>
		<!-- Bootstrap Core JS -->
		<script src="{{ asset('web/assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('web/assets/js/bootstrap.min.js') }}"></script>
		<!-- Slick JS -->
		<script src="{{ asset('web/assets/js/slick.js') }}"></script>
		<!-- Custom JS -->
		<script src="{{ asset('web/assets/js/script.js') }}"></script>
        <script>
            const time=new Date().getTime(),footerURL=`{{ asset('web_content/footer.json') }}?t=${time}`;fetch(footerURL).then(e=>e.json()).then(e=>{document.getElementById("footer-paragraph").innerText=e[0].paragraph,document.getElementById("footer-address").innerText=e[0].contactUs.address,document.getElementById("footer-contact").innerHTML+=e[0].contactUs.contact,document.getElementById("footer-email").innerHTML+=e[0].contactUs.email,""!==e[0].socialLinks.facebook&&(document.getElementById("social-links").innerHTML+=`<li><a href='${e[0].socialLinks.facebook}' target='_blank'><i class='fab fa-facebook'></i> </a> </li>`),""!==e[0].socialLinks.instagram&&(document.getElementById("social-links").innerHTML+=`<li><a href='${e[0].socialLinks.instagram}' target='_blank'><i class='fab fa-instagram'></i> </a> </li>`),""!==e[0].socialLinks.twitter&&(document.getElementById("social-links").innerHTML+=`<li><a href='${e[0].socialLinks.twitter}' target='_blank'><i class='fab fa-twitter'></i> </a> </li>`),""!==e[0].socialLinks.linkedin&&(document.getElementById("social-links").innerHTML+=`<li><a href='${e[0].socialLinks.linkedin}' target='_blank'><i class='fab fa-linkedin'></i> </a> </li>`)});
        </script>

	</body>
</html>


