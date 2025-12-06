<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Commonwealth Emergency Response System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/Logocircle.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
:root {
    --primary: #1fbf44;
    --primary-dark: #0c8e2d;
    --light-green: #e9ffef;
    --soft-bg: #f6fff8;
    --text: #1b1b1b;
    --muted: #555;
    --glass: rgba(255, 255, 255, 0.7);
    --shadow: rgba(0,0,0,0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: "Poppins", sans-serif;
    background: white;
    color: var(--text);
}

/* HEADER */
header {
    width: 100%;
    position: fixed;
    top: 0;
    background: white;
    padding: 18px 0;
    box-shadow: 0 2px 10px var(--shadow);
    z-index: 1000;
}
header .container {
    width: 90%;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo {
    display: flex;
    align-items: center;
    gap: 14px;
}
.logo img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
}
.logo h1 {
    font-size: 1.4rem;
    font-weight: 700;
}
.logo p {
    font-size: .8rem;
    color: var(--muted);
}
.nav-buttons a {
    padding: 10px 25px;
    border-radius: 30px;
    font-weight: 600;
    font-size: .9rem;
    text-decoration: none;
    transition: 0.3s ease;
}
.btn-login {
    border: 2px solid var(--primary);
    color: var(--primary);
}
.btn-login:hover {
    background: var(--light-green);
}
.btn-register {
    background: var(--primary);
    color: white;
}
.btn-register:hover {
    background: var(--primary-dark);
}

/* HERO */
.hero {
    padding: 160px 0 115px;
    text-align: center;
    background: linear-gradient(to bottom, #ffffff, #f2fff4);
}
.hero h1 {
    font-size: 3rem;
    color: var(--primary-dark);
    letter-spacing: 1px;
}
.hero p {
    max-width: 700px;
    margin: 10px auto 30px;
    color: var(--muted);
    font-size: 1.1rem;
}

/* SERVICES */
.services {
    padding: 100px 0;
    background: white;
}
.section-title {
    text-align: center;
    margin-bottom: 50px;
}
.section-title h2 {
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--primary-dark);
}
.section-title p {
    max-width: 500px;
    margin: auto;
    color: var(--muted);
}

.services-grid {
    width: 70%;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}
.service-card {
    padding: 30px;
    background: var(--glass);
    border-radius: 16px;
    backdrop-filter: blur(12px);
    border: 1px solid #dfeee4;
    box-shadow: 0 8px 18px var(--shadow);
    transition: 0.3s ease;
}
.service-card:hover {
    transform: translateY(-8px);
}
.service-card h3 {
    font-size: 1.35rem;
    margin-bottom: 12px;
    color: var(--primary-dark);
}
.service-card p {
    color: var(--muted);
}

/* MAP SECTION */
.map-section {
    padding: 110px 0;
    background: var(--soft-bg);
}
.map-container {
    width: 90%;
    margin: auto;
    display: flex;
    gap: 40px;
    align-items: center;
}
.map-info {
    flex: 1;
}
.map-info h2 {
    font-size: 2.1rem;
    margin-bottom: 12px;
    color: var(--primary-dark);
}
.map-info p {
    margin-bottom: 20px;
    color: var(--muted);
}
.contact-details {
    background: white;
    padding: 22px;
    border-radius: 16px;
    box-shadow: 0 5px 15px var(--shadow);
}
.contact-item {
    display: flex;
    gap: 15px;
    margin-bottom: 18px;
}
.contact-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--light-green);
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--primary);
    font-size: 1.3rem;
}
.map-wrapper {
    flex: 1;
    height: 430px;
    border-radius: 18px;
    overflow: hidden;
    border: 2px solid var(--primary);
    box-shadow: 0 10px 20px var(--shadow);
}
#map {
    height: 100%;
    width: 100%;
}

/* FOOTER */
footer {
    background: #0e3a1c;
    color: white;
    padding: 70px 0 35px;
}
.footer-content {
    width: 90%;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap: 30px;
}
.footer-column h3 {
    font-size: 1.2rem;
    margin-bottom: 12px;
}
.footer-links li {
    list-style: none;
    margin-bottom: 12px;
}
.footer-links a {
    text-decoration: none;
    color: white;
    opacity: 0.85;
    transition: .3s;
}
.footer-links a:hover {
    opacity: 1;
}
.footer-bottom {
    text-align: center;
    opacity: .7;
    margin-top: 35px;
    font-size: .85rem;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
    <div class="container">
        <div class="logo">
            <img src="./img/logocircle.png">
            <div>
                <h1>Barangay Commonwealth</h1>
                <p>Emergency Response System</p>
            </div>
        </div>

        <div class="nav-buttons">
            <a href="login/login.php" class="btn-login">Login</a>
            <a href="login/register.php" class="btn-register">Register</a>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <h1>Emergency Response & Information</h1>
    <p>Providing rapid emergency assistance, real-time coordination, and life-saving services within Barangay Commonwealth.</p>
</section>

<!-- SERVICES -->
<section class="services">
    <div class="section-title">
        <h2>Emergency Operations</h2>
        <p>All core functions of the Emergency Response System</p>
    </div>

    <div class="services-grid">
        <div class="service-card">
            <h3>Emergency Call Logging</h3>
            <p>Automatically records all incoming emergency calls for proper documentation and incident flow.</p>
        </div>

        <div class="service-card">
            <h3>Incident Prioritization</h3>
            <p>Sorts emergency cases based on severity for optimized dispatching.</p>
        </div>

        <div class="service-card">
            <h3>Responder Allocation</h3>
            <p>Assigns available responders according to urgency and proximity.</p>
        </div>

        <div class="service-card">
            <h3>GPS Tracking</h3>
            <p>Live tracking of responders and emergency locations through real-time mapping.</p>
        </div>

        <div class="service-card">
            <h3>Response Time Analytics</h3>
            <p>Analyzes response patterns to improve efficiency.</p>
        </div>

        <div class="service-card">
            <h3>Coordination Portal</h3>
            <p>Inter-agency communication platform for seamless emergency management.</p>
        </div>
    </div>
</section>

<!-- MAP SECTION -->
<section class="map-section">
    <div class="map-container">

        <div class="map-info">
            <h2>Real-Time Emergency Info</h2>
            <p>Monitor emergency events, responder location, and station availability in real time.</p>

            <div class="contact-details">
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-location-dot"></i></div>
                    <div><h4>Station</h4>Commonwealth Ave, Quezon City</div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div><h4>Hotline</h4>911</div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div><h4>Open</h4>24/7 Emergency Response</div>
                </div>
            </div>
        </div>

        <div class="map-wrapper">
            <div id="map"></div>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h3>Barangay Commonwealth</h3>
            <p>Emergency Response System ensuring community safety and faster response.</p>
        </div>

        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="#">Emergency Hotline</a></li>
                <li><a href="#">Report Incident</a></li>
                <li><a href="#">Map Tracking</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Contact</h3>
            <p>Commonwealth Ave, Quezon City</p>
            <p>Hotline: 911</p>
        </div>
    </div>

    <div class="footer-bottom">
        © 2025 Barangay Commonwealth Emergency Response System
    </div>
</footer>

<!-- MAP JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map("map").setView([14.6760, 121.0843], 15);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

L.marker([14.6760, 121.0843]).addTo(map)
    .bindPopup("<b>Barangay Commonwealth Fire Station</b><br>Active 24/7");
</script>

</body>
</html>
