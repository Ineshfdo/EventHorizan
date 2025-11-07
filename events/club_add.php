<?php
session_start();

// ===== Admin Authentication =====
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

require_once('../includes/db_connection.php'); // DB connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $club_name = $_POST['club_name'];
    $club_description = $_POST['club_description'];
    $uploadPath = "../uploads/";

    function uploadImage($inputName, $uploadPath) {
        if (!empty($_FILES[$inputName]["name"])) {
            $fileName = time() . "_" . basename($_FILES[$inputName]["name"]);
            move_uploaded_file($_FILES[$inputName]["tmp_name"], $uploadPath . $fileName);
            return $fileName;
        }
        return null;
    }

    $main_image = uploadImage("main_image", $uploadPath);
    $img1 = uploadImage("extra_image_1", $uploadPath);
    $img2 = uploadImage("extra_image_2", $uploadPath);
    $img3 = uploadImage("extra_image_3", $uploadPath);

    // Insert into clubs table
    $sql = "INSERT INTO clubs 
        (club_name, club_description, club_main_image, club_extra_image_1, club_extra_image_2, club_extra_image_3, created_at)
        VALUES (:club_name, :club_description, :main_image, :img1, :img2, :img3, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':club_name' => $club_name,
        ':club_description' => $club_description,
        ':main_image' => $main_image,
        ':img1' => $img1,
        ':img2' => $img2,
        ':img3' => $img3
    ]);

    header("Location: manage_clubs.php?added=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Club - Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100 flex flex-col md:flex-row min-h-screen">

<!-- Sidebar -->
<aside class="hidden md:flex flex-col w-64 p-6 bg-black text-white flex-shrink-0">
  <h2 class="text-xl font-bold mb-8">EventHorizan Admin</h2>
  <nav class="flex flex-col gap-4 flex-1">
    <a href="dashboard.php" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800">Dashboard</a>
    <a href="club_add.php" class="flex items-center gap-3 p-2 bg-gray-800 rounded-lg">Add Club</a>
    <a href="manage_clubs.php" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800">Manage Clubs</a>
    <a href="event_add.php" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800">Add Event</a>
    <a href="manage_events.php" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800">Manage Events</a>
    <a href="admin_logout.php" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800 mt-2">Logout</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-6 md:p-10">
  <h1 class="text-2xl font-semibold mb-6">Add New Club</h1>

  <div class="max-w-3xl bg-white p-8 shadow-lg rounded-xl mx-auto">
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">

      <div>
        <label class="block font-medium mb-1">Club Name</label>
        <input type="text" name="club_name" class="w-full border p-2 rounded" required>
      </div>

      <div>
        <label class="block font-medium mb-1">Club Description</label>
        <textarea name="club_description" rows="4" class="w-full border p-2 rounded" required></textarea>
      </div>

      <div>
        <label class="block font-medium mb-1">Main Image</label>
        <input type="file" name="main_image" class="w-full border p-2 rounded" required>
      </div>

      <div>
        <label class="block font-medium mb-1">Extra Image 1</label>
        <input type="file" name="extra_image_1" class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block font-medium mb-1">Extra Image 2</label>
        <input type="file" name="extra_image_2" class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block font-medium mb-1">Extra Image 3</label>
        <input type="file" name="extra_image_3" class="w-full border p-2 rounded">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
        Add Club
      </button>
    </form>
  </div>
</main>

</body>
</html>
