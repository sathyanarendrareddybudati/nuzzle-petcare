    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-about">
                        <h5 class="mb-4">About PetCare</h5>
                        <p class="mb-4">Connecting loving homes with wonderful pets. We help you find your perfect furry companion and provide the best care for your pets.</p>
                        <div class="social-links d-flex">
                            <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="d-flex align-items-center justify-content-center me-3" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="d-flex align-items-center justify-content-center" aria-label="Pinterest">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            <a href="index.php" class="d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 small"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="pets.php" class="d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 small"></i> Browse Pets
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 small"></i> About Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#contact" class="d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 small"></i> Contact
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 small"></i> FAQ
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-4">Contact Us</h5>
                    <ul class="list-unstyled contact-info">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                            <span>123 Pet Street, City, Country</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-phone me-3 mt-1"></i>
                            <a href="tel:+1234567890" class="text-decoration-none">+1 234 567 890</a>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-envelope me-3 mt-1"></i>
                            <a href="mailto:info@petcare.com" class="text-decoration-none">info@petcare.com</a>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-clock me-3 mt-1"></i>
                            <span>Mon - Fri: 9:00 - 18:00</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-3">
                    <h5 class="mb-4">Newsletter</h5>
                    <p class="mb-4">Subscribe to our newsletter for the latest pet listings, care tips, and special offers.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-primary px-3" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyPolicy" required>
                            <label class="form-check-label small" for="privacyPolicy">
                                I agree to the <a href="#" class="text-decoration-underline">Privacy Policy</a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Copyright -->
            <hr class="my-4 border-light opacity-10">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 small">&copy; <?php echo date('Y'); ?> PetCare. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none small">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <span class="mx-2">•</span>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none small">Terms of Service</a>
                        </li>
                        <li class="list-inline-item">
                            <span class="mx-2">•</span>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none small">Sitemap</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Activate Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add active class to current nav item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = location.pathname.split('/').pop() || 'index.php';
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>