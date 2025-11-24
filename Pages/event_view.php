<?php
include('../includes/header.php');
include('../includes/db_connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
    echo "Invalid Event ID";
    exit;
}

$event_id = intval($_GET['id']);

// ===== Auto-delete events older than 30 days =====
$deleteOld = $pdo->prepare("DELETE FROM events WHERE event_date < DATE_SUB(NOW(), INTERVAL 30 DAY)");
$deleteOld->execute();

// ===== Fetch event details =====
$query = "SELECT * FROM events WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    echo "Event not found!";
    exit;
}

/* Fetch linked club */
$club = null;
if (!empty($event['club_id'])) {
    $clubQuery = "SELECT * FROM clubs WHERE id = ?";
    $clubStmt = $pdo->prepare($clubQuery);
    $clubStmt->execute([$event['club_id']]);
    $club = $clubStmt->fetch();
}

// Check if event is in the past
$eventPast = (strtotime($event['event_date']) < time());
?>


<!-- ========================
       EVENT VIEW STYLES
======================== -->
<style>
:root {
  --primary: #007aff;
  --border: #e5e7eb;
  --text-dark: #0f172a;
  --text-muted: #6b7280;
  --transition: all 0.3s ease;
}

/* === Floating shapes === */
.floating-shape {
  position: absolute;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(147,51,234,0.08));
  animation: float 8s ease-in-out infinite;
  pointer-events: none;
  z-index: 0;
}

.shape-1 { 
  width: 200px; 
  height: 200px; 
  top: 10%; 
  left: 8%; 
}

.shape-2 { 
  width: 140px; 
  height: 140px; 
  top: 60%; 
  right: 10%; 
  animation-delay: 2s; 
}

.shape-3 { 
  width: 100px; 
  height: 100px; 
  bottom: 10%; 
  left: 15%; 
  animation-delay: 4s; 
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

/* === iOS Button (Enhanced with liquid glass effect) === */
.ios-btn-primary {
  color: white;
  background: linear-gradient(135deg, #007aff, #0056d8);
  border: none;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(10px);
  box-shadow: 0 8px 25px rgba(0,122,255,0.25);
  padding: 1rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  text-decoration: none;
  display: inline-block;
  position: relative;
  overflow: hidden;
}

.ios-btn-primary::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  transition: left 0.5s ease;
}

.ios-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 35px rgba(0,122,255,0.35);
}

.ios-btn-primary:hover::before {
  left: 100%;
}

/* === Back Button === */
.event-back-btn {
  background: #f8fafc;
  color: var(--text-dark);
  border: 2px solid #e5e7eb;
  padding: 0.75rem 1.5rem;
  border-radius: 50px;
  font-weight: 600;
  transition: var(--transition);
  text-decoration: none;
  display: inline-block;
}

.event-back-btn:hover {
  background: #3b82f6;
  color: white;
  border-color: #3b82f6;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}

/* ======================
   EVENT GALLERY WITH GLASS EFFECT
====================== */
.event-gallery-section {
  margin: 40px 0;
  padding: 2rem 0;
}

.event-image-card {
  border: 1px solid rgba(255, 255, 255, 0.3);
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border-radius: 1.5rem;
  padding: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  cursor: pointer;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.event-image-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.event-image-card:hover {
  transform: translateY(-6px) scale(1.02);
  border-color: var(--primary);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.event-image-card:hover::before {
  opacity: 1;
}

.event-image-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  border-radius: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
  position: relative;
  z-index: 2;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  aspect-ratio: 4/3;
}

/* Make images wider on larger screens */
@media (min-width: 768px) {
  .event-image-card img {
    height: 280px;
    aspect-ratio: 16/10;
  }
}

@media (min-width: 1024px) {
  .event-image-card img {
    height: 300px;
    aspect-ratio: 16/9;
  }
}

.event-image-card:hover img {
  transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
  .shape-1 { width: 150px; height: 150px; }
  .shape-2 { width: 100px; height: 100px; }
  .shape-3 { width: 80px; height: 80px; }
  
  .event-image-card img {
    height: 220px;
    aspect-ratio: 16/9;
  }
}
</style>

<!-- ========================
       EVENT VIEW CARD
======================== -->
<div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-xl p-10 mt-16 rounded-3xl shadow-xl border border-gray-200 relative overflow-hidden">
    <!-- Floating shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <div class="relative z-10">

    <!-- Main Image -->
    <img src="../uploads/<?= htmlspecialchars($event['main_image']) ?>" 
         class="w-full h-72 object-cover rounded-2xl shadow-lg mb-6" />

    <!-- Title -->
    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4">
        <?= htmlspecialchars($event['title']) ?>
    </h1>

    <!-- Event Details -->
    <div class="space-y-2 text-gray-600 text-sm">
        <p><span class="font-semibold text-gray-900">Event Date & Time:</span> <?= $event['event_date'] ?></p>
        <p><span class="font-semibold text-gray-900">Venue:</span> <?= htmlspecialchars($event['venue']) ?></p>
        <p><span class="font-semibold text-gray-900">Price:</span> 
            <?= !empty($event['price']) ? 'LKR ' . number_format($event['price'], 2) : 'Free' ?>
        </p>

        <?php if (!empty($event['ticket_url'])): ?>
        <p>
            <span class="font-semibold text-gray-900">Buy Tickets:</span>
            <a href="<?= htmlspecialchars($event['ticket_url']) ?>" 
               target="_blank" 
               class="text-blue-600 underline hover:text-blue-700 transition">
                Click Here
            </a>
        </p>
        <?php endif; ?>
    </div>

    <!-- Description -->
    <p class="text-gray-800 text-lg leading-relaxed mt-6 mb-8 whitespace-pre-line">
        <?= nl2br(htmlspecialchars($event['description'])) ?>
    </p>

    <!-- Extra Images - Gallery Grid -->
    <?php if (!empty($event['extra_image_1']) || !empty($event['extra_image_2']) || !empty($event['extra_image_3'])): ?>
    <div class="event-gallery-section">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-6">Event Gallery</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0.5">
            <?php if (!empty($event['extra_image_1'])): ?>
            <div class="event-image-card">
                <img src="../uploads/<?= htmlspecialchars($event['extra_image_1']) ?>" 
                     alt="Event Image 1" />
            </div>
            <?php endif; ?>
            
            <?php if (!empty($event['extra_image_2'])): ?>
            <div class="event-image-card">
                <img src="../uploads/<?= htmlspecialchars($event['extra_image_2']) ?>" 
                     alt="Event Image 2" />
            </div>
            <?php endif; ?>
            
            <?php if (!empty($event['extra_image_3'])): ?>
            <div class="event-image-card <?= empty($event['extra_image_1']) && empty($event['extra_image_2']) ? 'md:col-span-2' : '' ?>">
                <img src="../uploads/<?= htmlspecialchars($event['extra_image_3']) ?>" 
                     alt="Event Image 3" />
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Buttons -->
    <div class="flex flex-wrap gap-4 mt-10">

        <!-- Go Back -->
        <a href="index.php" class="event-back-btn">
           Go Back
        </a>

        <!-- Add Reminder -->
        <?php if ($eventPast): ?>
            <span class="px-5 py-2.5 bg-gray-400 text-white rounded-full shadow cursor-not-allowed">
                Add Reminder (Event Passed)
            </span>

        <?php elseif (isset($_SESSION['user_id'])): ?>
            <a href="addReminder.php?event_id=<?= $event_id ?>" class="ios-btn-primary">
               Add Reminder
            </a>

        <?php else: ?>
            <a href="login.php" class="ios-btn-primary">
               Add Reminder
            </a>
        <?php endif; ?>

        <!-- View Club -->
        <?php if ($club): ?>
        <a href="club_view.php?id=<?= $club['id'] ?>" class="ios-btn-primary">
           View Club
        </a>
        <?php endif; ?>

    </div>
    </div>

</div>

<br><br><br>

<?php include('../includes/footer.php'); ?>
