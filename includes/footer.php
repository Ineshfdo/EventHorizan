<script src="https://cdn.tailwindcss.com"></script>

<style>
  :root {
    --primary: #007aff;
    --primary-light: #409cff;
    --glass: rgba(255, 255, 255, 0.7);
    --glass-border: rgba(255, 255, 255, 0.3);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Footer Link Hover Effects */
  .footer-link {
    position: relative;
    transition: var(--transition);
    cursor: pointer;
  }

  .footer-link::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    transition: width 0.3s ease;
  }

  .footer-link:hover {
    color: var(--primary);
    transform: translateX(4px);
  }

  .footer-link:hover::before {
    width: 100%;
  }

  /* Footer Section Title */
  .footer-section-title {
    position: relative;
    padding-bottom: 0.5rem;
  }

  .footer-section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 2px;
  }
</style>

<footer class="mt-12 bg-white/70 backdrop-blur-xl border-t border-white/20 shadow-inner">

  <!-- MAIN FOOTER CONTENT -->
  <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

    <!-- LOGO + INFO -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left">
      <img src="../Images/apiit.png" alt="Logo" class="w-28 mb-3 drop-shadow-sm">

      <ul class="space-y-1 text-gray-600 text-sm">
        <li class="font-semibold text-gray-900">Event & Club Management System</li>
        <li>Colombo, Sri Lanka</li>
        <li>+94 77 748 9289</li>
        <li>support@eventclub.lk</li>
      </ul>
    </div>

    <!-- EVENTS SECTION -->
    <div class="flex flex-col items-center md:items-start">
      <h3 class="footer-section-title font-semibold text-gray-900 text-lg mb-3">Events</h3>
      <ul class="space-y-1 text-gray-600 text-sm">
        <li><a href="#" class="footer-link inline-block">Upcoming Events</a></li>
        <li><a href="#" class="footer-link inline-block">Featured Events</a></li>
        <li><a href="#" class="footer-link inline-block">Past Events</a></li>
        <li><a href="#" class="footer-link inline-block">Book a Ticket</a></li>
        <li><a href="#" class="footer-link inline-block">Event Calendar</a></li>
      </ul>
    </div>

    <!-- CLUBS SECTION -->
    <div class="flex flex-col items-center md:items-start">
      <h3 class="footer-section-title font-semibold text-gray-900 text-lg mb-3">Clubs</h3>
      <ul class="space-y-1 text-gray-600 text-sm">
        <li><a href="../pages/clubs.php" class="footer-link inline-block">All Clubs</a></li>
        <li><a href="#" class="footer-link inline-block">Join a Club</a></li>
        <li><a href="#" class="footer-link inline-block">Top Rated Clubs</a></li>
        <li><a href="#" class="footer-link inline-block">Student Communities</a></li>
        <li><a href="#" class="footer-link inline-block">Club Activities</a></li>
      </ul>
    </div>

    <!-- QUICK LINKS -->
    <div class="flex flex-col items-center md:items-start">
      <h3 class="footer-section-title font-semibold text-gray-900 text-lg mb-3">Quick Links</h3>
      <ul class="space-y-1 text-gray-600 text-sm">
        <li><a href="../pages/index.php" class="footer-link inline-block">Home</a></li>
        <li><a href="#" class="footer-link inline-block">Dashboard</a></li>
        <li><a href="../pages/login.php" class="footer-link inline-block">Login / Register</a></li>
        <li><a href="#" class="footer-link inline-block">About</a></li>
        <li><a href="#" class="footer-link inline-block">Contact</a></li>
      </ul>
    </div>

  </div>

  <!-- COPYRIGHT BAR -->
  <div class="border-t border-white/20 bg-white/60 backdrop-blur-xl py-3">
    <div class="max-w-7xl mx-auto px-4 flex justify-center">
      <p class="text-gray-600 text-xs">&copy; 2025 Event & Club Management System. All rights reserved.</p>
    </div>
  </div>

</footer>
