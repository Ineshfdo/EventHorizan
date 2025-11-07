<?php
// File: club_view.php
include('../includes/header.php');
include('../includes/db_connection.php');

if (!isset($_GET['id'])) {
    echo "Invalid club ID";
    exit;
}

$club_id = $_GET['id'];

/* Fetch the club info */
$query = "SELECT * FROM clubs WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$club_id]);
$club = $stmt->fetch();

if (!$club) {
    echo "Club not found";
    exit;
}

/* Fetch all events linked to this club */
$eventQuery = "SELECT * FROM events WHERE club_id = ?";
$eventStmt = $pdo->prepare($eventQuery);
$eventStmt->execute([$club_id]);
$events = $eventStmt->fetchAll();
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">

    <!-- Main Club Image -->
    <img src="../uploads/<?= $club['club_main_image'] ?>" 
         class="w-full h-60 object-cover rounded-lg mb-5">

    <!-- Extra Club Images -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <?php if (!empty($club['club_extra_image_1'])): ?>
            <img src="../uploads/<?= $club['club_extra_image_1'] ?>" class="rounded-lg h-40 w-full object-cover">
        <?php endif; ?>
        <?php if (!empty($club['club_extra_image_2'])): ?>
            <img src="../uploads/<?= $club['club_extra_image_2'] ?>" class="rounded-lg h-40 w-full object-cover">
        <?php endif; ?>
        <?php if (!empty($club['club_extra_image_3'])): ?>
            <img src="../uploads/<?= $club['club_extra_image_3'] ?>" class="rounded-lg h-40 w-full object-cover">
        <?php endif; ?>
    </div>

    <!-- Club Name & Description -->
    <h1 class="text-3xl font-bold mb-4"><?= $club['club_name'] ?></h1>

    <p class="text-gray-700 text-lg leading-relaxed mb-4">
        <?= nl2br($club['club_description']) ?>
    </p>

    <!-- Related Events -->
    <div class="text-sm font-semibold text-blue-600 mb-2">
        <p>Related Events:</p>
        <?php if($events): ?>
            <?php foreach ($events as $event): ?>
                <p class="hover:text-blue-800">
                    <a href="../events/event_view.php?id=<?= $event['id'] ?>">
                       - <?= $event['title'] ?>
                    </a>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events found for this club.</p>
        <?php endif; ?>
    </div>

</div>
<br><br><br><br>
<?php include('../includes/footer.php'); ?>
