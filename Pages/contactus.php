<?php
$title = "Contact Us";                  // ✅ Page title
include('../includes/header.php');     // ✅ Import main header (navigation + styling)
?>

<div class="hero-section bg-blue-600 text-white py-16 md:py-24 text-center rounded-b-3xl shadow-lg">
    <div class="container mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Contact Event Horizon</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
            Your trusted partner for university events and clubs. We’d love to hear from you!
        </p>
    </div>
</div>

<main class="container mx-auto px-6 md:px-0 py-12">
    <div class="grid md:grid-cols-2 gap-12 items-center">

        <div>
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d"
                 alt="Contact Image"
                 class="rounded-2xl shadow-lg">
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Send Us a Message</h2>

            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label class="block text-gray-600 mb-2">Full Name</label>
                    <input type="text" placeholder="Enter your name"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-600 mb-2">Email Address</label>
                    <input type="email" placeholder="Enter your email"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-600 mb-2">Inquiry Type</label>
                    <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option>General Inquiry</option>
                        <option>Event Support</option>
                        <option>Club Partnership</option>
                        <option>Technical Assistance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-600 mb-2">Message</label>
                    <textarea rows="5" placeholder="Write your message..."
                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-full font-semibold shadow-md">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</main>

<section class="bg-gray-100 py-16">
    <div class="container mx-auto text-center grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">📞<h3 class="font-semibold mt-2">Phone</h3><p class="text-gray-500 mt-1">+1 (123) 456-7890</p></div>
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">✉️<h3 class="font-semibold mt-2">Email</h3><p class="text-gray-500 mt-1">support@eventhorizon.com</p></div>
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">📍<h3 class="font-semibold mt-2">Office</h3><p class="text-gray-500 mt-1">45 City Road, New York, USA</p></div>
    </div>
</section>

<?php include('../includes/footer.php'); ?>  <!-- ✅ Import footer -->
