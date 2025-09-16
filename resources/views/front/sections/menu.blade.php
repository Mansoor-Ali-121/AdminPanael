<header class="social-menu">
    <div class="social-menu-content base-bg-red white-color">
        <div class="social-menu-content-left">
            <a href="mailto:info@sofaclean.ch" target="_blank" style="text-decoration: none;">
                <div class="social-menu-email" style="display: flex; align-items: center;">
                    <img src="/assets/icons/email.svg" height="22" width="22" alt="Email Icon">
                    <p class="white-color" style="margin-left: 8px;">info@sofaclean.ch</p>
                </div>
            </a>
            <a href="https://wa.me/+41764136183" target="_blank">
                <div class="social-menu-phone">
                    <img src="/assets/icons/phone.svg" height="22" width="22" alt="phone">
                    <p class="white-color">+41 (76) 413 61 83</p>
                </div>
            </a>
            <div class="social-menu-location">
                <img src="/assets/icons/location.svg" height="22" width="22" alt="location">
                <p>8050 Zurich</p>
            </div>
        </div>
        <div class="social-menu-content-right">
            <div class="social-menu-facebook">
                <a href="https://www.facebook.com/people/Sofacleanch/61575050244000/" target="_blank">
                    <img src="/assets/icons/facebook.svg" alt="facebook">
                </a>
            </div>
            <div class="social-menu-instagram">
                <a href="https://www.instagram.com/sofaclean.ch/" target="_blank">
                    <img src="/assets/icons/instagram.svg" alt="instagram">
                </a>
            </div>
            <div class="social-menu-twitter">
                <a href="https://www.youtube.com/watch?v=dtyF1tJ8OmU&t=2s&ab_channel=sofacleanZurich" target="_blank">
                    <img src="/assets/icons/youtube.svg" alt="youtube">
                </a>
            </div>
        </div>
    </div>

    <nav>
        <div class="main-menu">
            <div class="main-menu-content">
                <div class="main-menu-content-left">
                    <div class="main-menu-logo">
                        <a href="/en">
                            <img src="/assets/images/logo.webp" alt="Sofa Clean">
                        </a>
                    </div>

                    <div class="language-switcher align-items-center gap-2 me-3 mobileonlyicon">
                        <a class="nav-link" href="/"><img src="/assets/icons/german.svg" height="15px" /> DE</a>
                    </div>

                    <button class="hamburger-menu" type="button" aria-label="Menu" aria-expanded="false">
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                    </button>

                    <div class="main-menu-nav" id="mainMenuNav">
                        <ul>
                            <li><a href="/en">Home</a></li>
                            <li><a href="{{route('about')}}">About us</a></li>
                            <li class="nav-item has-dropdown" id="servicesItem">
                                <a class="nav-link dropdown-toggle has-sub" id="servicesLink"
                                    href="/en/cleaning-services" aria-haspopup="true" aria-expanded="false">
                                    Services
                                </a>
                                <ul class="dropdown-menu" aria-label="submenu">
                                    <li><a class="dropdown-item p-2" href="/en/cleaning-services">All Services</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/sofa-cleaning-zurich">Sofa Cleaning</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/mattress-cleaning-zurich">Mattress Cleaning</a>
                                    </li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/carpet-cleaning-zurich">Carpet Cleaning</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/curtain-cleaning-zurich">Curtain Cleaning</a>
                                    </li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/window-cleaning-zurich">Window Cleaning</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/balcony-cleaning-zurich">Balcony Cleaning</a>
                                    </li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/furniture-disposal-zurich">Furniture
                                            Disposal</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/disinfection-service-zurich">Disinfection
                                            Service</a></li>
                                    <li><a class="dropdown-item p-2"
                                            href="/en/cleaning-services/furniture-care-zurich">Furniture Care</a></li>
                                </ul>
                            </li>
                            <li><a href="/en/blogs">Blogs</a></li>
                            <li><a href="/en/contact">Contact</a></li>
                            <li class="mobile-language-flag d-lg-none mt-3">
                                <a href="/"><img src="/assets/icons/german.svg" alt="german" height="24"
                                        style="margin-right: 8px;">German</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="main-menu-content-right">
                    <div class="main-menu-language">
                        <a href="/"><img src="/assets/icons/german.svg" alt="german"></a>
                    </div>
                    <div class="main-menu-buttons">
                        <a href="/en/contact"><button class="menu-btn-one">Get in Touch</button></a>
                        <button class="menu-btn-two" data-bs-toggle="modal" data-bs-target="#freeEstimateModal">Get a
                            Free Estimate</button>
                    </div>
                    <div class="main-menu-youtube">
                        <a href="https://www.youtube.com/watch?v=dtyF1tJ8OmU&t=2s&ab_channel=sofacleanZurich"
                            target="_blank">
                            <img src="/assets/icons/youtube-logo.svg" alt="youtube">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Modal Form -->
<div class="modal fade" id="freeEstimateModal" tabindex="-1" aria-labelledby="freeEstimateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #00205b; padding: 40px; border-radius: 20px;">
            <div class="modal-header border-0">
                <h2 class="modal-title text-white" id="freeEstimateModalLabel">Get a Free Estimate</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="" id="modalEstimateForm" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="white-color">*Enter Your Name</label>
                        <input type="text" class="form-control rounded-pill" name="name"
                            placeholder="Full Name" required>
                        <small class="text-danger"><!-- error message here --></small>
                    </div>
                    <div class="col-md-6">
                        <label class="white-color">*Enter Your Email</label>
                        <input type="email" class="form-control rounded-pill" name="email"
                            placeholder="Email Address" required>
                        <small class="text-danger"><!-- error message here --></small>
                    </div>
                    <div class="col-md-12">
                        <label class="white-color">*Enter Your Phone Number</label>
                        <div class="phone-field-group gap-2">
                            <select name="country_code" class="form-select rounded-pill me-2"
                                style="max-width: 180px;">
                                <option value="+41" selected>+41 (Switzerland)</option>
                                <option value="+1">+1 (USA)</option>
                                <!-- add more options -->
                            </select>
                            <input type="number" name="phone"
                                class="form-control rounded-pill phone-field-group-input" placeholder="Phone Number"
                                required>
                        </div>
                        <small class="text-danger"><!-- error message here --></small>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        <label class="switch">
                            <input type="checkbox" id="modal_sameWhatsapp" onchange="toggleModalWhatsappField()"
                                checked>
                            <span class="slider round"></span>
                        </label>
                        <span class="white-color ms-2">WhatsApp number is same</span>
                    </div>
                    <div class="col-12 display-none" id="modal_whatsapp_number_field">
                        <label class="white-color">Enter WhatsApp number</label>
                        <div class="whatsapp-field-group gap-2">
                            <select name="country_code_for_whatsapp" class="form-select rounded-pill me-2"
                                style="max-width: 180px;">
                                <option value="+41" selected>+41 (Switzerland)</option>
                                <option value="+1">+1 (USA)</option>
                                <!-- add more options -->
                            </select>
                            <input type="number" name="whatsapp_number" class="form-control rounded-pill"
                                placeholder="Whatsapp number">
                        </div>
                        <small class="text-danger"><!-- error message here --></small>
                    </div>
                    <div class="col-12">
                        <label class="white-color">*Enter Your ZipCode</label>
                        <input type="number" class="form-control rounded-pill" name="zipcode"
                            placeholder="Zip Code" required>
                        <small class="text-danger"><!-- error message here --></small>
                    </div>
                    <div class="col-12">
                        <label class="white-color">Select Service</label>
                        <select class="form-select rounded-pill" name="service" required>
                            <option disabled selected>Select Service</option>
                            <option value="Sofa Cleaning">Sofa Cleaning</option>
                            <option value="Mattress Cleaning">Mattress Cleaning</option>
                            <option value="Carpet Cleaning">Carpet Cleaning</option>
                            <option value="Curtain Cleaning">Curtain Cleaning</option>
                            <option value="Window Cleaning">Window Cleaning</option>
                            <option value="Balcony Cleaning">Balcony Cleaning</option>
                            <option value="Furniture Disposal">Furniture Disposal</option>
                            <option value="Disinfection Service">Disinfection Service</option>
                            <option value="Furniture Care">Furniture Care</option>
                        </select>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill" id="submitBtn">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                aria-hidden="true"></span>
                            <span class="btn-text">Submit your request</span>
                        </button>
                        <div id="modal_loading"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#modalEstimateForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();
        let submitBtn = $('#submitBtn');
        let spinner = submitBtn.find('.spinner-border');
        let btnText = submitBtn.find('.btn-text');

        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Submitting...');

        $.ajax({
            url: '/submit-estimate', // replace with actual endpoint
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                btnText.text('Submit your request');

                if (res.status && res.redirect) {
                    window.location.href = res.redirect;
                } else {
                    alert(res.errors || res.message);
                }
            },
            error: function() {
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                btnText.text('Submit your request');
                alert('Something went wrong. Please try again.');
            }
        });
    });
</script>
