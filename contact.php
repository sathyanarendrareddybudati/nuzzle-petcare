<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Contact Us - PetCare';
require_once __DIR__ . '/includes/header.php';
?>

<div class="contact-header bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
        <p class="lead">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <form id="contactForm" method="POST" action="/submit-contact">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control form-control-lg" id="subject" name="subject">
                            </div>
                            <div class="form-group mb-4">
                                <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="p-4 rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                </div>
                <h4>Our Location</h4>
                <p class="text-muted mb-0">123 Pet Street<br>New York, NY 10001</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-4 rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-phone-alt fa-2x text-primary"></i>
                </div>
                <h4>Phone</h4>
                <p class="text-muted mb-0">+1 (123) 456-7890<br>Mon - Fri, 9:00 AM - 6:00 PM</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-4 rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-envelope fa-2x text-primary"></i>
                </div>
                <h4>Email</h4>
                <p class="text-muted mb-0">info@nuzzlepetcare.com<br>support@nuzzlepetcare.com</p>
            </div>
        </div>
    </div>
</div>

<div class="map-container">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215209179347!2d-73.98784492404432!3d40.74844097138992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
