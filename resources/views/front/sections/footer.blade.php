<footer class="footer-section">
    <div class="footer-section-content container">

        <div class="footer-new-top-section">
            <div class="footer-image-logo">
                <a href="/en">
                    <img src="/assets/images/logo.webp" alt="sofaclean">
                </a>
            </div>

            <div class="footer-section-top">
                <div class="footer-section-top-heading text-center mb-2 base-color">
                    <h2>Subscribe Our Newsletter</h2>
                </div>
                <form id="subscribe-top-form" class="footer-section-top-fields text-center">
                    <input class="footer-section-top-field-name" type="text" name="name" placeholder="Your Name" required>
                    <input class="footer-section-top-field-email" type="email" name="email" placeholder="Your Email" required>
                    <button class="footer-top-btn" type="submit">Subscribe</button>
                </form>
                <div id="subscribe-top-response" class="mt-2"></div>
            </div>
        </div>

        <div class="footer-section-bottom row">
            <div class="footer-section-bottom-first-column col-md-2">
                <h2 class="footer-section-bottom-heading">Contact us</h2>
                <p class="black-color">8050 Zurich</p>
                <a href="https://wa.me/+41764136183" target="_blank">
                    <p class="black-color">+41 (76) 413 61 83</p>
                </a>
                <a href="mailto:info@sofaclean.ch" target="_blank">
                    <p class="black-color">info@sofaclean.ch</p>
                </a>
            </div>

            <div class="footer-section-bottom-second-column col-md-2">
                <h2 class="footer-section-bottom-heading">Our Links</h2>
                <a href="/en/about-us"><p>About Us</p></a>
                <a href="/en/blogs"><p>Blogs</p></a>
                <a href="/en/cleaning-services/furniture-care-zurich"><p>Furniture Care</p></a>
                <a href="/en/contact"><p>Contact Us</p></a>
                <a href="/en/author"><p>Author</p></a>
            </div>

            <div class="footer-section-bottom-third-column col-md-2">
                <h2 class="footer-section-bottom-heading">Cleaning Services</h2>
                <a href="/en/cleaning-services/sofa-cleaning-zurich"><p>Sofa Cleaning</p></a>
                <a href="/en/cleaning-services/mattress-cleaning-zurich"><p>Mattress Cleaning</p></a>
                <a href="/en/cleaning-services/carpet-cleaning-zurich"><p>Carpet Cleaning</p></a>
                <a href="/en/cleaning-services/curtain-cleaning-zurich"><p>Curtain Cleaning</p></a>
            </div>

            <div class="footer-section-bottom-third-column col-md-2">
                <a href="/en/cleaning-services/window-cleaning-zurich"><p>Window Cleaning</p></a>
                <a href="/en/cleaning-services/balcony-cleaning-zurich"><p>Balcony Cleaning</p></a>
                <a href="/en/cleaning-services/furniture-disposal-zurich"><p>Furniture Disposal</p></a>
                <a href="/en/cleaning-services/disinfection-service-zurich"><p>Disinfection Service</p></a>
                <a href="/en/cleaning-services/furniture-care-zurich"><p>Furniture Care</p></a>
            </div>

            <div class="footer-section-bottom-fourth-column col-md-2">
                <h2 class="footer-section-bottom-heading">Subscribe</h2>
                <form id="subscribe-bottom-form" class="footer-section-bottom-fourth-column-fields">
                    <input class="footer-section-top-field-email" type="email" name="email" placeholder="Your Email" required>
                    <button class="footer-bottom-btn" type="submit">Send</button>
                </form>
                <div id="subscribe-bottom-response" class="mt-2"></div>
                <p id="subscribe-response" style="font-size:14px; margin-top:5px;"></p>

                <br>
                <div class="footer-section-bottom-fourth-column-field-icons mb-2">
                    <div class="social-menu-facebook">
                        <a href="https://www.facebook.com/people/Sofacleanch/61575050244000/" target="_blank">
                            <img src="/assets/icons/icons8-facebook.svg" alt="facebook">
                        </a>
                    </div>
                    <div class="social-menu-instagram">
                        <a href="https://www.instagram.com/sofaclean.ch/" target="_blank">
                            <img src="/assets/icons/icons8-instagram.svg" alt="instagram">
                        </a>
                    </div>
                    <div class="social-menu-twitter">
                        <a href="https://www.youtube.com/watch?v=dtyF1tJ8OmU&t=2s&ab_channel=sofacleanZurich" target="_blank">
                            <img src="/assets/icons/icons8-youtube.svg" alt="youtube">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="footer-section-bottom-bar white-color text-center base-bg">
        <p> © 2025 Sofaclean, All rights reserved. </p>
    </div>
</footer>

<!-- Floating Buttons -->
<div class="floating-buttons">
    <a href="/" class="language-switcher">
        <img src="/assets/icons/german.svg" class="flag-icon" alt="German" height="24" />
        DE
    </a>

    <a href="https://web.whatsapp.com/send?phone=+41764136183&text=Hello" class="whatsapp-button" target="_blank">
        <img src="/assets/images/whatsapp.png" alt="WhatsApp" width="40" height="40">
        <span class="whatsapp-label">Message Us</span>
    </a>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/assets/js/script.js"></script>

<!-- Subscription Scripts -->
<script>
    // Bottom form
    document.querySelector("#subscribe-bottom-form").addEventListener("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch("/front/subscribe", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alertify.set('notifier', 'position', 'bottom-left');
                if (data.status === "success") {
                    alertify.success(data.message);
                    this.reset();
                } else {
                    alertify.error(data.message);
                }
            })
            .catch(() => {
                alertify.error("❌ Error sending request.");
            });
    });

    // Top form
    document.querySelector("#subscribe-top-form").addEventListener("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch("/front/subscribeTop", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alertify.set('notifier', 'position', 'bottom-left');
                if (data.status === "success") {
                    alertify.success(data.message);
                    this.reset();
                } else {
                    alertify.error(data.message);
                }
            })
            .catch(() => {
                alertify.error("❌ Error sending request.");
            });
    });
</script>
<body>
</html>