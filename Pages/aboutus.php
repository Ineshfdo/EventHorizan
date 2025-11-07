<?php 
    $title = "About Us";  // ✅ Page title goes here
    include('../includes/header.php');   // ✅ Import Header
?>

<!-- Hero Section -->
<section class="hero-section bg-blue-600 text-white py-16 md:py-24 text-center rounded-b-3xl shadow-lg">
    <div class="container mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">About Event Horizon</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
            We are passionate about redefining how events and clubs are managed —
            making it simpler, smarter, and more engaging for everyone.
        </p>
    </div>
</section>

<!-- Story / Mission & Vision -->
<section class="container mx-auto px-6 md:px-0 py-16 space-y-10">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Story</h2>
        <p class="text-gray-600 leading-relaxed max-w-3xl mx-auto">
            Event Horizon was founded with one mission: to make event planning and club management seamless.
            From small gatherings to international conferences, we’ve helped thousands of organizers
            create memorable experiences.
            <br><br>
            Over the years, we’ve grown into a trusted partner for universities, corporations, and communities
            worldwide. Our system blends technology with creativity, empowering organizers with tools to manage
            registrations, memberships, payments, and communication — all in one place.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h2>
            <p class="text-gray-600 leading-relaxed">
                To empower event organizers and club managers with innovative digital solutions that save time,
                reduce stress, and maximize engagement.
            </p>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h2>
            <p class="text-gray-600 leading-relaxed">
                To be the global leader in event and club management systems — trusted by millions and
                recognized for excellence, reliability, and creativity.
            </p>
        </div>
    </div>
</section>

<!-- Features / Services -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-6 md:px-0 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-10">What We Offer</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                🎟
                <h3 class="font-semibold text-gray-700 mt-3">Event Management</h3>
                <p class="text-gray-600 mt-2">From ticketing to scheduling, we handle every aspect effortlessly.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                👥
                <h3 class="font-semibold text-gray-700 mt-3">Club Memberships</h3>
                <p class="text-gray-600 mt-2">Manage memberships, renewals, and communication.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                💳
                <h3 class="font-semibold text-gray-700 mt-3">Payments & Billing</h3>
                <p class="text-gray-600 mt-2">Secure online payments with automated invoices.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                📊
                <h3 class="font-semibold text-gray-700 mt-3">Analytics</h3>
                <p class="text-gray-600 mt-2">Insights into attendance, revenue & engagement.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                📩
                <h3 class="font-semibold text-gray-700 mt-3">Communication Tools</h3>
                <p class="text-gray-600 mt-2">Email, SMS, and notifications built in.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
                🌍
                <h3 class="font-semibold text-gray-700 mt-3">Global Reach</h3>
                <p class="text-gray-600 mt-2">Supporting international events and communities.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="container mx-auto px-6 md:px-0 py-16">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Meet Our Team</h2>
    <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-24 h-24 rounded-full mx-auto">
            <h3 class="font-semibold text-gray-700 mt-4">David Carter</h3>
            <p class="text-gray-500">Founder & CEO</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-24 h-24 rounded-full mx-auto">
            <h3 class="font-semibold text-gray-700 mt-4">Sophia Lee</h3>
            <p class="text-gray-500">Head of Operations</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <img src="https://randomuser.me/api/portraits/men/65.jpg" class="w-24 h-24 rounded-full mx-auto">
            <h3 class="font-semibold text-gray-700 mt-4">Michael Brown</h3>
            <p class="text-gray-500">Tech Lead</p>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-6 md:px-0 text-center grid md:grid-cols-4 gap-8">
        <div><h3 class="text-4xl font-bold">500+</h3><p>Events Managed</p></div>
        <div><h3 class="text-4xl font-bold">200+</h3><p>Club Partners</p></div>
        <div><h3 class="text-4xl font-bold">50,000+</h3><p>Happy Attendees</p></div>
        <div><h3 class="text-4xl font-bold">15+</h3><p>Countries Served</p></div>
    </div>
</section>

<!-- CTA -->
<section class="bg-blue-600 text-white py-16 text-center rounded-t-3xl">
    <h2 class="text-3xl font-bold mb-4">Join Event Horizon Today</h2>
    <p class="mb-6 max-w-xl mx-auto">Be part of the revolution in event and club management.</p>
    <a href="contact.php" class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 ios-button">
        Get in Touch
    </a>
</section>

<?php include('../includes/footer.php'); ?> <!-- ✅ Import Footer -->
