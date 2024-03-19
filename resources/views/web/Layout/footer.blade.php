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



<script>
    const time = new Date().getTime(), footerURL = `{{ asset('web_content/footer.json') }}?t=${time}`;
    fetch(footerURL).then(e => e.json()).then(e => {
        document.getElementById("footer-paragraph").innerText = e[0].paragraph, document.getElementById("footer-address").innerText = e[0].contactUs.address, document.getElementById("footer-contact").innerHTML += e[0].contactUs.contact, document.getElementById("footer-email").innerHTML += e[0].contactUs.email, "" !== e[0].socialLinks.facebook && (document.getElementById("social-links").innerHTML += `<li><a href='${e[0].socialLinks.facebook}' target='_blank'><i class='fab fa-facebook'></i> </a> </li>`), "" !== e[0].socialLinks.instagram && (document.getElementById("social-links").innerHTML += `<li><a href='${e[0].socialLinks.instagram}' target='_blank'><i class='fab fa-instagram'></i> </a> </li>`), "" !== e[0].socialLinks.twitter && (document.getElementById("social-links").innerHTML += `<li><a href='${e[0].socialLinks.twitter}' target='_blank'><i class='fab fa-twitter'></i> </a> </li>`), "" !== e[0].socialLinks.linkedin && (document.getElementById("social-links").innerHTML += `<li><a href='${e[0].socialLinks.linkedin}' target='_blank'><i class='fab fa-linkedin'></i> </a> </li>`)
    });
</script>



