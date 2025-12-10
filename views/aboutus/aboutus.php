<?php
// This PHP file serves the static HTML/CSS content for the About Us page.

// Variables (Optional: If you wanted dynamic data, you would fetch it here)
$page_title = "About Us - Nuzzle PetCare";
$brand_name = "Nuzzle";

// Start of HTML output
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '    <title>' . $page_title . '</title>';
echo '    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">';
echo '    <style>';
?>

        /* --- General Styles and Variables --- */
        :root {
            --orange: #ff7f41; /* Primary brand color */
            --dark-gray: #333333;
            --light-bg: #f5f5f5; /* Background color for lighter sections */
            --white: #ffffff;
            --text-color: #555555;
            --max-width: 1200px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 20px;
        }

        h2 {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 10px;
        }

        .section-header {
            text-align: center;
            padding: 60px 0 30px;
        }

        .btn-primary {
            background-color: var(--orange);
            color: var(--white);
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e56b30;
        }

        /* --- Header/Navbar --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            max-width: 100%;
            background-color: var(--white);
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--orange);
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            margin-left: 30px;
            font-weight: 600;
        }

        /* --- Hero Section --- */
        .hero {
            background-color: var(--light-bg);
            padding: 80px 0;
            display: flex;
            align-items: center;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
            padding-right: 40px;
        }

        .hero-text h1 {
            font-size: 44px;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 15px;
        }

        .hero-image {
            flex: 1;
            max-width: 50%;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        /* --- Our Journey Section --- */
        .journey-section {
            padding: 80px 0;
            text-align: center;
        }

        .journey-image {
            max-width: 700px;
            margin: 30px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .journey-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* --- Achievements Section --- */
        .achievements-section {
            text-align: center;
            padding-bottom: 80px;
        }

        .achievements-grid {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
        }

        .achievement-card {
            flex-basis: 30%;
            padding: 20px;
        }

        .achievement-card h3 {
            font-size: 36px;
            color: var(--dark-gray);
            font-weight: 700;
        }

        .achievement-card p {
            color: var(--text-color);
        }

        /* --- Partner Section (Orange BG) --- */
        .partner-section {
            background-color: var(--orange);
            color: var(--white);
            padding: 60px 0;
        }

        .partner-section h2 {
            color: var(--white);
            text-align: center;
        }

        /* --- Join Our Team (Pacaners) Section --- */
        .team-section {
            background-color: var(--light-bg);
            padding: 80px 0;
            text-align: center;
        }

        .team-section h2 {
            margin-top: 60px; /* Space after the initial text */
        }

        .team-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 40px auto 60px;
            max-width: 900px;
        }

        .team-member {
            width: 120px;
            text-align: center;
            margin: 10px;
        }

        .team-member img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 3px solid var(--orange);
        }

        .team-member h4 {
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            color: var(--dark-gray);
        }

        .team-member p {
            font-size: 12px;
            color: var(--text-color);
            margin: 0;
        }

        /* Pacaners Grid (Small Cards) */
        .pacaners-header {
            margin-bottom: 40px;
        }

        .pacaners-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding-top: 20px;
            padding-bottom: 80px;
        }

        .pacaner-card {
            background-color: var(--white);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            width: 30%;
            text-align: center;
        }

        .pacaner-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--dark-gray);
        }

        .pacaner-card p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .pacaner-card .btn-secondary {
            background-color: var(--light-bg);
            color: var(--dark-gray);
            padding: 8px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        /* --- Locations Section --- */
        .locations-section {
            text-align: center;
            padding: 40px 0 80px;
        }

        /* --- Footer/Join Locations Section (Orange BG) --- */
        .footer-cta {
            background-color: var(--orange);
            color: var(--white);
            padding: 80px 0;
            text-align: center;
        }

        .footer-cta h2 {
            color: var(--white);
            margin-bottom: 40px;
        }

        .footer-cta .btn-white {
            background-color: var(--white);
            color: var(--orange);
            border: 1px solid var(--white);
            margin: 0 10px;
        }
        
        .footer-cta .btn-white:hover {
            background-color: #ffe8d6;
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 900px) {
            .hero-content {
                flex-direction: column;
            }
            .hero-image {
                max-width: 100%;
                order: -1; /* Image on top on mobile */
            }
            .achievements-grid, .pacaners-grid {
                flex-direction: column;
                gap: 20px;
            }
            .pacaner-card {
                width: 90%;
            }
        }
<?php
echo '    </style>';
echo '</head>';
echo '<body>';
?>

    <header class="header">
        <div class="logo"><?php echo $brand_name; ?></div>
        <nav class="nav-links">
            <a href="#">Home</a>
            <a href="#">Services</a>
            <a href="#">About Us</a>
            <a href="#">Blog</a>
            <a href="#">Sign Up</a>
        </nav>
        <button class="btn-primary">Sign In</button>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Meet the <?php echo $brand_name; ?> <br>PetCare Team</h1>
                <p>We're dedicated to designing your paw-fect care system.</p>
                <p style="margin-top: 20px;">We believe every pet deserves the best care, and we've built our team around that core value.</p>
            </div>
            <div class="hero-image">
                <img src="https://via.placeholder.com/600x400?text=Two+Puppies" alt="Two cute puppies looking at the camera">
            </div>
        </div>
    </section>

    <section class="journey-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Journey</h2>
                <p><?php echo $brand_name; ?> PetCare was built with a simple mission: to simplify pet ownership. Our care started small, but our commitment to animals and owners is massive.</p>
            </div>
            <div class="journey-image">
                <img src="https://via.placeholder.com/700x350?text=Puppies+Huddle" alt="Three puppies huddled together looking cute">
            </div>
        </div>
    </section>

    <section class="achievements-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Achievements</h2>
            </div>
            <div class="achievements-grid">
                <div class="achievement-card">
                    <h3>2021</h3>
                    <p>Year We Dedicated</p>
                </div>
                <div class="achievement-card">
                    <h3>10K+</h3>
                    <p>Satisfied Pet Owners</p>
                </div>
                <div class="achievement-card">
                    <h3>5-Star</h3>
                    <p>App Store Rating</p>
                </div>
            </div>
        </div>
    </section>

    <section class="partner-section">
        <div class="container">
            <h2>Our trusted partners</h2>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <h2>Join Our Team</h2>
                <p>We are always looking for passionate people to join our pack! Our growing family.</p>
            </div>
            
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Man1" alt="Founder">
                    <h4>Ethan Miller</h4>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Man2" alt="Product">
                    <h4>Jana Brown</h4>
                    <p>Product Head</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Dog1" alt="Dog Model">
                    <h4>Buddy</h4>
                    <p>Surrogacy Model</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Dog2" alt="Cairn Terrier">
                    <h4>Coco</h4>
                    <p>Customer Tester</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Dog3" alt="Golden Retreiver">
                    <h4>Jax Allen</h4>
                    <p>Patient Care Manager</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Man3" alt="Tech Lead">
                    <h4>Dr. Amelia Evans</h4>
                    <p>Patient Care's Veteran</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Man4" alt="Marketing">
                    <h4>Will Harper</h4>
                    <p>Pet-Chain Expert</p>
                </div>
                <div class="team-member">
                    <img src="https://via.placeholder.com/120x120?text=Dog4" alt="Small Dog">
                    <h4>Luna</h4>
                    <p>Emergency Advisor</p>
                </div>
            </div>

            <div class="pacaners-header">
                <h2>Pacaners</h2>
                <p>We're keeping it simple! Everything we do is driven by delight of the pet.</p>
            </div>

            <div class="pacaners-grid">
                <div class="pacaner-card">
                    <h3>Patient Care</h3>
                    <p>We focus on compassion and comfort for every patient. <br>...and more</p>
                    <a href="#" class="btn-secondary">View Role</a>
                </div>
                <div class="pacaner-card">
                    <h3>Admin & Finance</h3>
                    <p>Keep the ship sailing smoothly, from budgeting to team support. <br>...and more</p>
                    <a href="#" class="btn-secondary">View Role</a>
                </div>
                <div class="pacaner-card">
                    <h3>Front-End Expert</h3>
                    <p>Crafting the perfect user experience for our website and app. <br>...and more</p>
                    <a href="#" class="btn-secondary">View Role</a>
                </div>
            </div>
        </div>
    </section>

    <section class="locations-section">
        <div class="container">
            <div class="section-header" style="padding-top: 0;">
                <h2>Our locations</h2>
                <p>We're currently growing and have offices across all major cities.</p>
            </div>
        </div>
    </section>

    <section class="footer-cta">
        <div class="container">
            <h2>Join our locations</h2>
            <button class="btn-white">Current Openings</button>
            <button class="btn-white">Recruitment Process</button>
        </div>
    </section>

<?php
// End of HTML output
echo '</body>';
echo '</html>';
?>