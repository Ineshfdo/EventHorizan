<?php
session_start();

include('../includes/header.php');
include('../includes/db_connection.php');

// Validate club ID
if (!isset($_GET['id'])) {
    echo "Invalid club ID";
    exit;
}

$club_id = intval($_GET['id']);

// Fetch club
$query = "SELECT * FROM clubs WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$club_id]);
$club = $stmt->fetch();

if (!$club) {
    echo "Club not found";
    exit;
}

/* FETCH UPCOMING EVENTS */
$eventQuery = "
    SELECT * FROM events 
    WHERE club_id = ? AND event_date >= CURDATE()
    ORDER BY event_date ASC
";
$eventStmt = $pdo->prepare($eventQuery);
$eventStmt->execute([$club_id]);
$events = $eventStmt->fetchAll();

/* AUTO PAST EVENTS */
$autoPastQuery = "
    SELECT *, 'auto' AS source_type FROM events 
    WHERE club_id = ? AND event_date < CURDATE()
    ORDER BY event_date DESC
";
$autoPastStmt = $pdo->prepare($autoPastQuery);
$autoPastStmt->execute([$club_id]);
$auto_past_events = $autoPastStmt->fetchAll();

/* MANUAL PAST EVENTS */
$manualPastQuery = "
    SELECT *, 'manual' AS source_type FROM past_events 
    WHERE club_id = ?
    ORDER BY created_at DESC
";
$manualPastStmt = $pdo->prepare($manualPastQuery);
$manualPastStmt->execute([$club_id]);
$manual_past_events = $manualPastStmt->fetchAll();

/* MERGE BOTH */
$past_events = array_merge($auto_past_events, $manual_past_events);
?>

<!-- =======================
       CLUB VIEW STYLES
======================= -->
<style>
:root {
  --primary: #007aff;
  --primary-light: #4da3ff;
  --glass: rgba(255, 255, 255, 0.8);
  --glass-border: rgba(255, 255, 255, 0.4);
  --shadow: rgba(0, 0, 0, 0.08);
  --text-dark: #0f172a;
  --text-muted: #6b7280;
  --radius-lg: 1.5rem;
}

/* === Animations === */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes shimmer {
  0% { background-position: -200px 0; }
  100% { background-position: calc(200px + 100%) 0; }
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out forwards;
}

.animate-fade-in {
  animation: fadeIn 1s ease-out forwards;
}

.animation-delay-200 {
  animation-delay: 0.2s;
}

.animation-delay-400 {
  animation-delay: 0.4s;
}

.animation-delay-600 {
  animation-delay: 0.6s;
}

/* Floating background shapes */
.floating-shape {
  position: absolute;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
  animation: float 6s ease-in-out infinite;
  pointer-events: none;
  z-index: 0;
}

.shape-1 {
  width: 200px;
  height: 200px;
  top: 10%;
  left: 5%;
  animation-delay: 0s;
}

.shape-2 {
  width: 150px;
  height: 150px;
  top: 60%;
  right: 10%;
  animation-delay: 2s;
}

.shape-3 {
  width: 100px;
  height: 100px;
  bottom: 20%;
  left: 15%;
  animation-delay: 4s;
}

.shape-4 {
  width: 120px;
  height: 120px;
  top: 20%;
  right: 20%;
  animation-delay: 1s;
}

/* Main container */
.club-view-container {
  position: relative;
  overflow: hidden;
}

/* Enhanced card styling */
.club-main-card {
  background: var(--glass);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid var(--glass-border);
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  position: relative;
  z-index: 1;
}

/* Hero section */
.hero-section {
  position: relative;
  overflow: hidden;
  border-radius: 1.5rem;
  margin-bottom: 2rem;
}

.hero-content {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
  color: white;
  padding: 2rem;
  z-index: 2;
}

.hero-title {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.hero-image {
  width: 100%;
  height: 500px;
  object-fit: cover;
  display: block;
}

/* Content grid */
.content-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2rem;
}

@media (max-width: 768px) {
  .content-grid {
    grid-template-columns: 1fr;
  }
}

/* Info cards */
.info-card {
  background: var(--glass);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid var(--glass-border);
  border-radius: 1.5rem;
  padding: 1.5rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  margin-bottom: 1.5rem;
}

.info-card:hover {
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

/* Extra images with glass effect */
.extra-image-card {
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

.extra-image-card::before {
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

.extra-image-card:hover {
  transform: translateY(-6px) scale(1.02);
  border-color: var(--primary);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.extra-image-card:hover::before {
  opacity: 1;
}

.extra-image-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
  position: relative;
  z-index: 2;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.extra-image-card:hover img {
  transform: scale(1.05);
}

/* Event cards */
.event-card {
  background: rgba(59, 130, 246, 0.1);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 1rem;
  padding: 1rem;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.event-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.05) 100%);
  opacity: 0;
  transition: all 0.3s ease;
}

.event-card:hover {
  transform: translateX(4px) translateY(-2px);
  border-color: var(--primary);
  box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
}

.event-card:hover::before {
  opacity: 1;
}

/* Past event cards */
.past-event-card {
  background: var(--glass);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid var(--glass-border);
  border-radius: 1.5rem;
  padding: 1.5rem;
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
  opacity: 0;
  transform: translateY(30px);
}

.past-event-card.animate-visible {
  opacity: 1;
  transform: translateY(0);
}

.past-event-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
  opacity: 0;
  transition: all 0.3s ease;
}

.past-event-card:hover {
  transform: translateY(-6px) scale(1.02);
  border-color: var(--primary);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.past-event-card:hover::before {
  opacity: 1;
}

/* Contact info card */
.contact-card {
  background: var(--glass);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid var(--glass-border);
  border-radius: 1.5rem;
  padding: 1.5rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.contact-card:hover {
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

/* iOS Button */
.ios-btn-primary {
  color: white;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
  border: none;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(10px);
  box-shadow: 0 6px 20px rgba(0,122,255,0.25);
  padding: 0.625rem 1.5rem;
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
  box-shadow: 0 8px 30px rgba(0,122,255,0.4);
}

.ios-btn-primary:hover::before {
  left: 100%;
}

/* Section titles */
.section-title {
  font-size: 1.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, var(--text-dark) 0%, #374151 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  position: relative;
  padding-bottom: 0.5rem;
  margin-bottom: 1.5rem;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, var(--primary), var(--primary-light));
  border-radius: 2px;
}

/* Tag styling */
.tag {
  display: inline-block;
  background: rgba(59, 130, 246, 0.1);
  color: var(--primary);
  padding: 0.25rem 0.75rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 600;
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
  .shape-1 { width: 150px; height: 150px; }
  .shape-2 { width: 120px; height: 120px; }
  .shape-3 { width: 80px; height: 80px; }
  .shape-4 { width: 100px; height: 100px; }
  .hero-title { font-size: 2rem; }
  .hero-image { height: 300px; }
}
</style>

<script>
// Intersection Observer for scroll animations
document.addEventListener('DOMContentLoaded', function() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-visible');
      }
    });
  }, observerOptions);

  document.querySelectorAll('.past-event-card').forEach(card => {
    observer.observe(card);
  });
});
</script>

<!-- =======================
        MAIN CONTENT
======================= -->
<div class="club-view-container max-w-5xl mx-auto mt-16 mb-28 px-4">
    <!-- Floating shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>

    <!-- Hero Section -->
    <div class="hero-section animate-fade-in">
        <?php if (!empty($club['club_main_image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($club['club_main_image']) ?>"
                 class="hero-image">
            <div class="hero-content">
                <h1 class="hero-title"><?= htmlspecialchars($club['club_name']) ?></h1>
                <div class="flex flex-wrap">
                    <?php if (!empty($club['contact_number_1'])): ?>
                        <span class="tag">Contact Available</span>
                    <?php endif; ?>
                    <?php if ($events): ?>
                        <span class="tag">Upcoming Events</span>
                    <?php endif; ?>
                    <?php if ($past_events): ?>
                        <span class="tag">Past Events</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="hero-image bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <h1 class="hero-title text-white text-center"><?= htmlspecialchars($club['club_name']) ?></h1>
            </div>
        <?php endif; ?>
    </div>

    <div class="content-grid">
        <!-- Main Content Column -->
        <div class="main-content">
            <!-- About Club Section -->
            <div class="info-card animate-fade-in-up">
                <h2 class="section-title">About Our Club</h2>
                <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                    <?= nl2br(htmlspecialchars($club['club_description'])) ?>
                </p>
            </div>

            <!-- EXTRA IMAGES GRID -->
            <?php if (!empty($club['club_extra_image_1']) || !empty($club['club_extra_image_2']) || !empty($club['club_extra_image_3'])): ?>
            <div class="info-card animate-fade-in-up animation-delay-200">
                <h2 class="section-title">Gallery</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php if (!empty($club['club_extra_image_1'])): ?>
                        <div class="extra-image-card">
                            <img src="../uploads/<?= htmlspecialchars($club['club_extra_image_1']) ?>"
                                 alt="Club Image 1"
                                 class="h-40">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($club['club_extra_image_2'])): ?>
                        <div class="extra-image-card">
                            <img src="../uploads/<?= htmlspecialchars($club['club_extra_image_2']) ?>"
                                 alt="Club Image 2"
                                 class="h-40">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($club['club_extra_image_3'])): ?>
                        <div class="extra-image-card">
                            <img src="../uploads/<?= htmlspecialchars($club['club_extra_image_3']) ?>"
                                 alt="Club Image 3"
                                 class="h-40">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- =======================
                UPCOMING EVENTS
            ======================== -->
            <div class="info-card animate-fade-in-up animation-delay-400">
                <h2 class="section-title">Upcoming Events</h2>

                <?php if ($events): ?>
                    <div class="space-y-3">
                    <?php foreach ($events as $event): ?>
                        <a href="event_view.php?id=<?= $event['id'] ?>"
                           class="event-card block p-4 text-gray-900 font-medium relative z-10">
                            <div class="flex justify-between items-center">
                                <span class="relative z-10"><?= htmlspecialchars($event['title']) ?></span>
                                <span class="text-sm text-gray-600"><?= htmlspecialchars($event['event_date']) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 italic">No upcoming events for this club.</p>
                <?php endif; ?>
            </div>

            <!-- =======================
                PAST EVENTS
            ======================== -->
            <div class="info-card animate-fade-in-up animation-delay-600">
                <h2 class="section-title">Past Events</h2>

                <?php if ($past_events): ?>
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php 
                        $index = 0;
                        foreach ($past_events as $p): 
                            $delayClass = ($index % 2 === 0) ? 'animation-delay-200' : 'animation-delay-400';
                            $index++;
                        ?>
                        <div class="past-event-card <?= $delayClass ?>">
                            <!-- MAIN IMAGE -->
                            <?php if (!empty($p['main_image'])): ?>
                                <img src="../uploads/<?= $p['main_image'] ?>"
                                     class="w-full h-48 object-cover rounded-xl shadow mb-4">
                            <?php endif; ?>

                            <!-- TITLE -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                <?= htmlspecialchars($p['title'] ?? $p['event_title']) ?>
                            </h3>

                            <!-- SHORT DESCRIPTION WITH SEE MORE -->
                            <?php
                                $desc = $p['description'] ?? $p['event_description'];
                                $words = explode(" ", $desc);
                                $short = implode(" ", array_slice($words, 0, 15));
                                $isLong = count($words) > 15;
                            ?>

                            <p class="text-gray-700 text-sm leading-relaxed mb-3">
                                <span class="short-desc"><?= htmlspecialchars($short) ?><?= $isLong ? '...' : '' ?></span>

                                <?php if ($isLong): ?>
                                    <span class="full-desc hidden"><?= nl2br(htmlspecialchars($desc)) ?></span>
                                    <button class="toggleDesc text-blue-600 text-sm underline">Show More</button>
                                <?php endif; ?>
                            </p>

                            <!-- DATE TYPE -->
                            <p class="text-xs text-gray-500">
                                <?= $p['source_type'] == "auto"
                                    ? "Event Date: " . htmlspecialchars($p['event_date'])
                                    : "Added On: " . htmlspecialchars($p['created_at']) ?>
                            </p>

                            <!-- EXTRA IMAGES -->
                            <?php if (!empty($p['extra_image_1']) || !empty($p['extra_image_2']) || !empty($p['extra_image_3'])): ?>
                            <div class="grid grid-cols-3 gap-2 mt-3">
                                <?php if (!empty($p['extra_image_1'])): ?>
                                    <img src="../uploads/<?= $p['extra_image_1'] ?>" 
                                         class="h-16 w-full object-cover rounded shadow">
                                <?php endif; ?>

                                <?php if (!empty($p['extra_image_2'])): ?>
                                    <img src="../uploads/<?= $p['extra_image_2'] ?>" 
                                         class="h-16 w-full object-cover rounded shadow">
                                <?php endif; ?>

                                <?php if (!empty($p['extra_image_3'])): ?>
                                    <img src="../uploads/<?= $p['extra_image_3'] ?>" 
                                         class="h-16 w-full object-cover rounded shadow">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 italic">No past events found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="sidebar">
            <!-- =======================
                CONTACT INFO
            ======================== -->
            <div class="contact-card animate-fade-in-up">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    Contact Information
                </h3>

                <?php if (!empty($club['contact_description_1'])): ?>
                    <p class="text-gray-700 mb-3 leading-relaxed"><?= nl2br(htmlspecialchars($club['contact_description_1'])) ?></p>
                <?php endif; ?>

                <?php if (!empty($club['contact_number_1'])): ?>
                    <p class="text-gray-700 mb-2 font-medium">Contact 1: <span class="text-blue-600"><?= htmlspecialchars($club['contact_number_1']) ?></span></p>
                <?php endif; ?>

                <?php if (!empty($club['contact_number_2'])): ?>
                    <p class="text-gray-700 font-medium">Contact 2: <span class="text-blue-600"><?= htmlspecialchars($club['contact_number_2']) ?></span></p>
                <?php endif; ?>
                
                <?php if (!empty($club['contact_number_1']) || !empty($club['contact_number_2'])): ?>
                    <div class="mt-4">
                        <a href="#" class="ios-btn-primary w-full text-center">Get In Touch</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="info-card animate-fade-in-up animation-delay-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="#" class="ios-btn-primary w-full text-center block">Join Club</a>
                    <a href="#" class="ios-btn-primary w-full text-center block" style="background: linear-gradient(135deg, #6b7280, #9ca3af);">Follow Club</a>
                    <a href="#" class="ios-btn-primary w-full text-center block" style="background: linear-gradient(135deg, #10b981, #34d399);">Share Club</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SHOW MORE SCRIPT -->
<script>
document.querySelectorAll(".toggleDesc").forEach(btn => {
    btn.addEventListener("click", () => {
        const parent = btn.parentElement;
        parent.querySelector(".short-desc").classList.toggle("hidden");
        parent.querySelector(".full-desc").classList.toggle("hidden");
        btn.textContent = btn.textContent === "Show More" ? "Show Less" : "Show More";
    });
});
</script>

<?php include('../includes/footer.php'); ?>