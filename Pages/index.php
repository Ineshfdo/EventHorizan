<?php
$title = "Home";
include('../includes/header.php');
include('../includes/db_connection.php');

// =====================
// Delete events older than 30 days
// =====================
$deleteStmt = $pdo->prepare("DELETE FROM events WHERE event_date < NOW() - INTERVAL 30 DAY");
$deleteStmt->execute();

/* ✅ Fetch events with date and time */
$query = "SELECT id, title, event_date FROM events ORDER BY event_date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ✅ Fetch ONLY latest 4 clubs with their first event (if exists) */
$clubQuery = "SELECT clubs.*, events.title AS event_title
              FROM clubs
              LEFT JOIN events ON events.club_id = clubs.id
              GROUP BY clubs.id
              ORDER BY clubs.id DESC
              LIMIT 4";
$clubStmt = $pdo->prepare($clubQuery);
$clubStmt->execute();
$clubs = $clubStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
const events = <?php echo json_encode($events); ?>;
</script>

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-4">
        <button id="prevMonth" class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">&lt;</button>
        <h2 id="monthYear" class="text-lg font-semibold"></h2>
        <button id="nextMonth" class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">&gt;</button>
    </div>

    <div class="grid grid-cols-7 mb-2 text-center font-bold text-sm text-gray-700">
        <div>Sun</div> <div>Mon</div> <div>Tue</div>
        <div>Wed</div> <div>Thu</div> <div>Fri</div> <div>Sat</div>
    </div>

    <div id="calendarDays" class="grid grid-cols-7 text-center text-sm gap-2"></div>
</div>

<script>
const calendarDays = document.getElementById("calendarDays");
const monthYear = document.getElementById("monthYear");
let currentDate = new Date();

function renderCalendar() {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();

    monthYear.textContent = currentDate.toLocaleString("default", { month: "long", year: "numeric" });
    calendarDays.innerHTML = "";

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    const today = new Date();
    const todayStr = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;

    // Empty slots for first day of month
    for (let i = 0; i < firstDay; i++) {
        calendarDays.innerHTML += `<div></div>`;
    }

    for (let day = 1; day <= lastDate; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        const isToday = dateStr === todayStr;

        const todaysEvents = events.filter(e => e.event_date.startsWith(dateStr));

        let dayClass = `p-2 rounded-lg transition duration-200 ${isToday ? "bg-red-100 border-2 border-red-400 shadow-md" : "hover:bg-blue-50 cursor-pointer"}`;

        if (todaysEvents.length > 0) {
            let eventHTML = todaysEvents.map(e => {
                const time = new Date(e.event_date).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                return `<p class="text-xs bg-gray-100 p-1 rounded mb-1 hover:bg-blue-200 cursor-pointer" 
                          onclick="window.location.href='../events/event_view.php?id=${e.id}'">
                          ${e.title} <span class="text-gray-500">(${time})</span>
                        </p>`;
            }).join('');
            
            calendarDays.innerHTML += `
                <div class="${dayClass}">
                    <div class="font-semibold mb-1 ${isToday ? 'text-yellow-700' : ''}">${day}</div>
                    ${eventHTML}
                </div>`;
        } else {
            calendarDays.innerHTML += `<div class="${dayClass}"><div class="font-semibold ${isToday ? 'text-yellow-700' : ''}">${day}</div></div>`;
        }
    }
}

document.getElementById("prevMonth").onclick = () => { 
    currentDate.setMonth(currentDate.getMonth() - 1); 
    renderCalendar(); 
};
document.getElementById("nextMonth").onclick = () => { 
    currentDate.setMonth(currentDate.getMonth() + 1); 
    renderCalendar(); 
};

renderCalendar();
</script>

<!-- ✅ TOP 4 CLUB SECTION -->
<div class="max-w-5xl mx-auto mt-16">
    <h2 class="text-2xl font-bold mb-4 text-center">Top Clubs</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($clubs as $club): ?>
        <div class="bg-white p-4 shadow-md rounded-lg hover:shadow-xl transition cursor-pointer"
             onclick="window.location.href='../clubs/club_view.php?id=<?= $club['id'] ?>'">

            <img src="../uploads/<?= $club['club_main_image'] ?>"
                 class="h-48 w-full object-cover rounded-lg mb-3">

            <h3 class="text-lg font-bold text-gray-900"><?= $club['club_name'] ?></h3>

            <p class="text-gray-600"><?= $club['club_description'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<br><br><br>
<?php include('../includes/footer.php'); ?>
