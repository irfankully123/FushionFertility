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
    <p class="h1 mb-5">Terms and Conditions</p>

    <h2>1. Introduction</h2>
    <p>1.1 These terms and conditions govern your use of the doctor appointment website ("the Website"). By accessing and
        using the Website, you agree to comply with these terms and conditions. If you do not agree with any part of these
        terms and conditions, please refrain from using the Website.</p>

    <h2>2. Use of the Website</h2>
    <p>2.1 The Website provides an online platform where users can schedule doctor appointments and access related services.</p>
    <p>2.2 You must be at least 18 years old or have parental consent to use the Website.</p>
    <p>2.3 You agree to provide accurate and up-to-date information during the registration process and when booking appointments.</p>
    <p>2.4 You are responsible for maintaining the confidentiality of your account login credentials and for all activities that occur under your account.</p>

    <h2>3. Appointment Booking</h2>
    <p>3.1 The Website allows you to schedule doctor appointments based on availability.</p>
    <p>3.2 The availability of doctors and appointment slots is subject to change without notice.</p>
    <p>3.3 The Website does not guarantee the availability of a specific doctor or appointment slot.</p>
    <p>3.4 You agree to provide accurate and relevant information when booking appointments, including your medical history and any specific requirements.</p>
    <p>3.5 The Website is not responsible for any consequences resulting from inaccurate or incomplete information provided by users.</p>

    <h2>4. Doctor-Patient Relationship</h2>
    <p>4.1 The Website acts as a platform to connect patients with doctors but does not create a doctor-patient relationship between users and doctors.</p>
    <p>4.2 The Website does not endorse, recommend, or guarantee the qualifications, expertise, or quality of services provided by doctors.</p>
    <p>4.3 It is your responsibility to evaluate and choose a suitable doctor based on your own judgment and preferences.</p>

    <h2>5. Payment and Fees</h2>
    <p>5.1 The Website may require payment for certain services, such as booking fees or consultation charges.</p>
    <p>5.2 All payments made through the Website are subject to the terms and conditions of the payment gateway provider.</p>
    <p>5.3 You agree to provide accurate and complete payment information and authorize the Website to charge the applicable fees to your chosen payment method.</p>

    <h2>6. Cancellations and Refunds</h2>
    <p>6.1 Cancellation policies vary based on the doctor's practice and may be subject to additional fees.</p>
    <p>6.2 The Website does not guarantee refunds for cancelled appointments or any dissatisfaction with the services provided by doctors.</p>
    <p>6.3 Refund requests, if applicable, must be submitted according to the procedures outlined on the Website.</p>

    <h2>7. Intellectual Property</h2>
    <p>7.1 The Website and its contents are protected by copyright, trademark, and other intellectual property laws.</p>
    <p>7.2 You may not reproduce, distribute, modify, or use any part of the Website without the prior written consent of the Website's owner.</p>

<h2>8. Disclaimer and Limitation of Liability</h2>
<p>8.1 The Website is provided on an "as is" basis and does not guarantee the accuracy, completeness, or reliability of the information provided.</p>
<p>8.2 The Website is not liable for any damages, losses, or injuries arising from your use of the Website or the services provided by doctors.</p>
<p>8.3 The Website is not responsible for any interactions, disputes, or agreements between users and doctors.</p>
<p>8.4 The Website does not provide medical advice and should not be considered a substitute for professional medical care.</p>

<h2>9. Privacy and Data Protection</h2>
<p>9.1 The Website collects and processes personal information in accordance with its Privacy Policy.</p>
<p>9.2 By using the Website, you consent to the collection, use, and disclosure of your personal information as described in the Privacy Policy.</p>

<h2>10. Modifications to the Terms and Conditions</h2>
<p>10.1 The Website reserves the right to modify these terms and conditions at any time without prior notice.</p>
<p>10.2 Your continued use of the Website after any modifications indicates your acceptance of the updated terms and conditions.</p>


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
