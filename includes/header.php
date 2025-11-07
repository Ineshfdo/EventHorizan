<?php
// File: header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? "EventHorizan"; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Header -->
<header class="bg-white fixed top-0 left-0 w-full z-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="../pages/index.php" class="flex items-center">
          <img class="w-28" src="../Images/apiit.png" alt="Logo">
        </a>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-6 items-center">
        <a href="../pages/index.php" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Home</a>
        <a href="../pages/clubs.php" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Clubs</a>
        <a href="../pages/reminders.php" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Reminders</a>
        <a href="../pages/contactus.php" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Contact Us</a>
        <a href="../pages/aboutus.php" class="nav-link text-gray-700 hover:text-blue-600 font-medium">About Us</a>

        <!-- User / Login -->
        <?php if(isset($_SESSION['email'])): ?>
          <?php $firstLetter = strtoupper($_SESSION['email'][0]); ?>
          <div class="flex items-center gap-2 ml-4">
            <div class="w-10 h-10 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center">
              <?= $firstLetter ?>
            </div>
            <a href="../pages/logout.php" class="px-3 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
              Logout
            </a>
          </div>
        <?php else: ?>
          <a href="../pages/login.php" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Login
          </a>
        <?php endif; ?>
      </nav>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-white">
    <nav class="px-4 pt-2 pb-4 space-y-1">
      <a href="../pages/index.php" class="nav-link block text-gray-700 hover:text-blue-600 font-medium">Home</a>
      <a href="../pages/clubs.php" class="nav-link block text-gray-700 hover:text-blue-600 font-medium">Clubs</a>
      <a href="../pages/reminders.php" class="nav-link block text-gray-700 hover:text-blue-600 font-medium">Reminders</a>
      <a href="../pages/contactus.php" class="nav-link block text-gray-700 hover:text-blue-600 font-medium">Contact Us</a>
      <a href="../pages/aboutus.php" class="nav-link block text-gray-700 hover:text-blue-600 font-medium">About Us</a>

      <?php if(isset($_SESSION['email'])): ?>
        <?php $firstLetter = strtoupper($_SESSION['email'][0]); ?>
        <div class="flex items-center gap-2 mt-2">
          <div class="w-10 h-10 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center">
            <?= $firstLetter ?>
          </div>
          <a href="../pages/logout.php" class="px-3 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
            Logout
          </a>
        </div>
      <?php else: ?>
        <a href="../pages/login.php" class="block text-center mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
          Login
        </a>
      <?php endif; ?>
    </nav>
  </div>

  <div class="border-b border-gray-200 w-full"></div>
</header>

<!-- Push content below header -->
<div class="pt-20"></div>

<script>
  const menuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');
  const navLinks = document.querySelectorAll('.nav-link');

  // Mobile toggle
  if(menuButton){
    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

  // Highlight current page
  const currentPath = window.location.pathname.split("/").pop();
  navLinks.forEach(link => {
    const linkPath = link.getAttribute('href').split("/").pop();
    if (linkPath === currentPath || (currentPath === "" && linkPath === "index.php")) {
      link.classList.add('text-blue-600');
      link.classList.remove('text-gray-700');
    }
  });
</script>
