<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - PetCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header Section -->
<div class="contact-header bg-primary text-white py-5">
  <div class="container text-center">
    <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
    <p class="lead">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
  </div>
</div>

<!-- Contact Form -->
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body p-5">
            <form id="contactForm" method="POST" action="#">
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

<!-- Contact Info -->
<div class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4 text-center">
        <div class="icon-circle">
          <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
        </div>
        <h4>Our Location</h4>
        <p class="text-muted mb-0">28, rue Notre des Champs<br>PARIS, FR 75006</p>
      </div>
      <div class="col-md-4 text-center">
        <div class="icon-circle">
          <i class="fas fa-phone-alt fa-2x text-primary"></i>
        </div>
        <h4>Phone</h4>
        <p class="text-muted mb-0">+33 78965432<br>Mon - Fri, 9:00 AM - 6:00 PM</p>
      </div>
      <div class="col-md-4 text-center">
        <div class="icon-circle">
          <i class="fas fa-envelope fa-2x text-primary"></i>
        </div>
        <h4>Email</h4>
        <p class="text-muted mb-0">info@nuzzlepetcare.com<br>support@nuzzlepetcare.com</p>
      </div>
    </div>
  </div>
</div>

<!-- Google Map -->
<div class="map-container">
  <iframe 
    src="https://www.google.com/maps?q=28+Rue+Notre-Dame+des+Champs,+75006+Paris&output=embed"
    width="100%" 
    height="450" 
    style="border:0;" 
    allowfullscreen 
    loading="lazy">
  </iframe>
</div>

<!-- Footer -->
<footer class="text-center py-4 bg-primary text-white">
  <p class="mb-0">&copy; 2025 Nuzzle PetCare. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>