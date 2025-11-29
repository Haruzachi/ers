<?php
session_start();
require_once '../../config/db_connection.php';

// ---------------------
// Handle AJAX Fetch Request
// ---------------------
if (isset($_GET['action']) && $_GET['action'] === 'fetch_notifications') {
    // Fetch all notifications
    $stmt = $pdo->query("SELECT * FROM emergency_notifications ORDER BY created_at DESC");
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total notifications
    $totalNotifications = count($notifications);

    // Return both notifications and total count
    echo json_encode([
        'total' => $totalNotifications,
        'notifications' => $notifications
    ]);
    exit();
}

// ---------------------
// Normal Page Render
// ---------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT first_name, middle_name, last_name, role FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($user) {
    $first_name = htmlspecialchars($user['first_name']);
    $middle_name = htmlspecialchars($user['middle_name']);
    $last_name = htmlspecialchars($user['last_name']);
    $role = htmlspecialchars($user['role']);
    
    $full_name = $first_name;
    if (!empty($middle_name)) {
        $full_name .= " " . $middle_name;
    }
    $full_name .= " " . $last_name;
} else {
    $full_name = "User";
    $role = "USER";
}

$stmt = null;

// FETCH INCIDENT COUNTS BY TYPE (for PIE CHART + TABLE 1)
$stmt = $pdo->query("
    SELECT type, COUNT(*) AS total
    FROM emergency_notifications
    GROUP BY type
");
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert PHP → JS arrays
$typeLabels = [];
$typeCounts = [];

foreach ($types as $row) {
    $typeLabels[] = $row['type'];
    $typeCounts[] = $row['total'];
}

// FETCH MONTHLY COUNTS (for BAR CHART)
$stmt2 = $pdo->query("
    SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS total
    FROM emergency_notifications
    GROUP BY MONTH(created_at)
    ORDER BY MONTH(created_at)
");
$months = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$monthLabels = [];
$monthCounts = [];

foreach ($months as $row) {
    $monthLabels[] = $row['month'];
    $monthCounts[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/Logocircle.png">
    <link rel="stylesheet" href="../../css/emergency.css">
</head>

<body>
    
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon">
                    <img src="../../img/Logocircle.png" alt="Fire & Rescue Logo" style="width: 40px; height: 45px;">
                </div>
                <span class="logo-text">Emergency & Response</span>
            </div>
            
          <!-- Menu Section -->
<div class="menu-section">
    <p class="menu-title">RESPONSE MANAGEMENT</p>
    
    <div class="menu-items">
        <a href="../staff_dashboard.php" class="menu-item" id="dashboard-menu">
            <div class="icon-box icon-bg-red">
                <i class='bx bxs-dashboard icon-red'></i>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <div class="menu-item" onclick="toggleSubmenu('fire-incident')">
            <div class="icon-box icon-bg-orange">
                <i class='bx bxs-alarm-exclamation icon-orange'></i>
            </div>
            <span class="font-medium">Barangay Emergency Logging Management</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="fire-incident" class="submenu">
            <a href="../Sub1/Logging.php" class="submenu-item">Logging</a>
        
        </div>
        
        <div class="menu-item" onclick="toggleSubmenu('volunteer')">
            <div class="icon-box icon-bg-blue">
                <i class='bx bxs-user-detail icon-blue'></i>
            </div>
            <span class="font-medium">Incident Prioritization</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="volunteer" class="submenu">
            <a href="../Sub2/Severity.php" class="submenu-item">Severity</a>
        </div>
        
        <div class="menu-item" onclick="toggleSubmenu('inventory')">
            <div class="icon-box icon-bg-green">
                <i class='bx bxs-cube icon-green'></i>
            </div>
            <span class="font-medium">Local Resource Allocation</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="inventory" class="submenu">
            <a href="../Sub3/Dispatch.php" class="submenu-item">Manual Dispatch</a>
            <a href="../Sub3/Logs.php" class="submenu-item">Allocation Log</a>
        </div>
        
        <div class="menu-item" onclick="toggleSubmenu('schedule')">
            <div class="icon-box icon-bg-purple">
                <i class='bx bxs-calendar icon-purple'></i>
            </div>
            <span class="font-medium">GPS Tracking of Barangay Responders</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="schedule" class="submenu">
            <a href="../Sub4/Map.php" class="submenu-item">Live Map Interface</a>
            <a href="../Sub4/Hazard.php" class="submenu-item">Hazard Mapping</a>
        </div>
        
        <div class="menu-item active" onclick="toggleSubmenu('training')">
            <div class="icon-box icon-bg-teal">
                <i class='bx bxs-graduation icon-teal'></i>
            </div>
            <span class="font-medium">Response Time Reporting</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="training" class="submenu">
            <a href="" class="submenu-item active">Performance Dashboard</a>
            <a href="../Sub5/Tracker.php" class="submenu-item">Time Event</a>
        </div>
        
        <div class="menu-item" onclick="toggleSubmenu('inspection')">
            <div class="icon-box icon-bg-yellow">
                <i class='bx bxs-check-shield icon-yellow'></i>
            </div>
            <span class="font-medium">Barangay Coordination Portal</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="inspection" class="submenu">
            <a href="../Sub6/Barangay.php" class="submenu-item">Barangay Communication</a>
            <a href="../Sub6/Alerts.php" class="submenu-item">Notification Alerts</a>
        </div>
        
        <div class="menu-item" onclick="toggleSubmenu('postincident')">
            <div class="icon-box icon-bg-pink">
                <i class='bx bxs-file-doc icon-pink'></i>
            </div>
            <span class="font-medium">After-Action Feedback Management</span>
            <svg class="dropdown-arrow menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div id="postincident" class="submenu">
            <a href="../Sub7/Suggestion.php" class="submenu-item">Suggestion & Recommendation</a>
            <a href="../Sub7/Evaluation.php" class="submenu-item">Performance Evaluation</a>
        </div>
    </div>
    
    <p class="menu-title" style="margin-top: 32px;">GENERAL</p>
    
    <div class="menu-items">
        <a href="#" class="menu-item">
            <div class="icon-box icon-bg-teal">
                <i class='bx bxs-cog icon-teal'></i>
            </div>
            <span class="font-medium">Settings</span>
        </a>
        
        <a href="#" class="menu-item">
            <div class="icon-box icon-bg-indigo">
                <i class='bx bxs-help-circle icon-indigo'></i>
            </div>
            <span class="font-medium">Profile</span>
        </a>
        
        <a href="../../includes/logout.php" class="menu-item">
            <div class="icon-box icon-bg-red">
                <i class='bx bx-log-out icon-red'></i>
            </div>
            <span class="font-medium">Logout</span>
        </a>
    </div>
</div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-content">
                    <div class="search-container">
                        <div class="search-box">
                            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" placeholder="Search response" class="search-input">
                            <kbd class="search-shortcut">🔎</kbd>
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <button class="theme-toggle" id="theme-toggle">
                            <i class='bx bx-moon'></i>
                            <span>Dark Mode</span>
                        </button>
                        <div class="time-display" id="time-display">
                            <i class='bx bx-time time-icon'></i>
                            <span id="current-time">Loading...</span>
                        </div>
                        <button class="header-button">
                            <svg class="header-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                     <!-- Notification Bell -->
<button class="header-button" id="notifBtn">
    <svg class="header-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 
        6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 
        8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 
        0 11-6 0v-1m6 0H9"></path>
    </svg>
    <span id="notifBadge" class="notif-badge">0</span>
</button>

<!-- Notification Panel -->
<div id="notificationsPanel" class="notifications-panel">
    <div class="notifications-header">
        <h4>Notifications</h4>
        <button id="closeNotifPanel">&times;</button>
    </div>
    <ul id="notificationsList" class="notifications-list"></ul>
</div>

<style>
    
    .header {
    position: relative; /* or fixed if you want it always visible */
    z-index: 1000; /* above the map */
}
    /* Notification badge */
.notif-badge {
    background: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    position: absolute;
    top: -5px;
    right: -5px;
}

.notifications-panel {
    position: fixed; /* stays above all content */
    top: 60px;       /* below your header */
    right: 20px;
    width: 300px;
    max-height: 400px;
    overflow-y: auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 9999; /* higher than header */
    display: none; /* hidden by default */
}

.notifications-panel .notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.notifications-panel .notifications-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.notifications-panel .notifications-list li {
    padding: 10px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.notifications-panel .notifications-list li:hover {
    background: #f0f0f0;
}
</style>
                        <div class="user-profile">
                             <img src="../../img/Logocircle.png" alt="User" class="user-avatar">
                            <div class="user-info">
                                <p class="user-name"><?php echo $full_name; ?></p>
                                <p class="user-email"><?php echo $role; ?></p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- dashboard content palitan nyo nalnag ng content na gamit sa system nyo -->
            <div class="dashboard-content">
        

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    margin-top: 25px;
}

.stat-card {
    padding: 35px;
    border-radius: 25px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    background-color: #ffffff;
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.2);
}

.stat-card-primary {
    background: linear-gradient(135deg, #0BB85F, #1DBF72); /* Green gradient */
    color: white;
}

.stat-header .stat-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
}

canvas {
    border-radius: 15px;
    background-color: rgba(255,255,255,0.05);
    padding: 15px;
}

.stat-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: 15px;
}

.stat-table th {
    background-color: #0BB85F;
    color: white;
    font-weight: 600;
    padding: 12px 15px;
    text-align: left;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    font-size: 16px;
}

.stat-table td {
    background-color: #f4f6f8;
    padding: 12px 15px;
    font-size: 15px;
    color:black;
    border-bottom: 1px solid #e2e8f0;
}

.stat-table tr:last-child td {
    border-bottom: none;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

.stat-table tr:hover td {
    background-color: #d1f7d6;
    transition: 0.3s;
}

.stat-info {
    margin-top: 15px;
    font-size: 15px;
    font-weight: 600;
    opacity: 0.9;
}
</style>

<div class="stats-grid">

    <!-- INCIDENT DISTRIBUTION PIE -->
    <div class="stat-card stat-card-primary">
        <div class="stat-header">
            <span class="stat-title">Incident Distribution</span>
        </div>

        <canvas id="pieChart" style="height:280px;"></canvas>

        <div class="stat-info">
            <span>Total by Type</span>
        </div>
    </div>

    <div class="stat-card stat-card-primary">
    <div class="stat-header">
        <span class="stat-title">Monthly Incidents</span>
    </div>

    <canvas id="monthlyLoadingChart" style="height:280px;"></canvas>

    <div class="stat-info">
        <span>Incidents per Month (Animated)</span>
    </div>
</div>

    <!-- INCIDENT TYPES TABLE -->
    <div class="stat-card stat-card-white">
        <div class="stat-header">
            <span class="stat-title">Incident Types</span>
        </div>

        <table class="stat-table">
            <tr>
                <th>Type</th>
                <th>Count</th>
            </tr>
            <?php foreach ($types as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <!-- MONTHLY TABLE -->
    <div class="stat-card stat-card-primary">
        <div class="stat-header">
            <span class="stat-title">Monthly Breakdown</span>
        </div>

        <table class="stat-table">
            <tr>
                <th>Month</th>
                <th>Count</th>
            </tr>
            <?php foreach ($months as $row): ?>
            <tr>
                <td><?= $row['month'] ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

</div>

<script>
    // INCIDENT DISTRIBUTION PIE CHART
    new Chart(document.getElementById("pieChart"), {
        type: "pie",
        data: {
            labels: <?= json_encode($typeLabels) ?>,
            datasets: [{
                data: <?= json_encode($typeCounts) ?>,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        font: { size: 14, weight: 'bold' }
                    }
                }
            }
        }
    });

   const monthlyCtx = document.getElementById("monthlyLoadingChart").getContext("2d");

// Total incidents for calculation
const totalMonthly = <?= array_sum($monthCounts) ?>;
const monthLabels = <?= json_encode($monthLabels) ?>;
const monthCounts = <?= json_encode($monthCounts) ?>;

// Calculate percentages
const monthPercentages = monthCounts.map(count => ((count / totalMonthly) * 100).toFixed(1));

new Chart(monthlyCtx, {
    type: 'doughnut',
    data: {
        labels: monthLabels,
        datasets: [{
            data: monthCounts,
            backgroundColor: [
                '#00ffbfff','#00fa00ff','#0051ffff','#ff0000ff','#ff00aaff','#BBFFD6',
                '#D4FFE6','#A3F5B8','#69E891','#39D66C','#20C85B','#0BAF4B'
            ],
            borderWidth: 4,
            borderColor: '#ffffff',
            hoverOffset: 10
        }]
    },
    options: {
        cutout: '60%', // makes it donut-style
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    font: { size: 14, weight: 'bold' }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw;
                        let percent = monthPercentages[context.dataIndex];
                        return `${label}: ${value} (${percent}%)`;
                    }
                }
            }
        },
        animation: {
            animateRotate: true,
            duration: 2000
        }
    }
});
</script>



            </div>
        </div>
    </div>
    

    <script>
const notifBtn = document.getElementById('notifBtn');
const notificationsPanel = document.getElementById('notificationsPanel');
const closeNotifPanel = document.getElementById('closeNotifPanel');
const notificationsList = document.getElementById('notificationsList');
const notifBadge = document.getElementById('notifBadge');

notifBtn.addEventListener('click', () => {
    notificationsPanel.style.display = notificationsPanel.style.display === 'block' ? 'none' : 'block';
});

closeNotifPanel.addEventListener('click', () => {
    notificationsPanel.style.display = 'none';
});

function fetchNotifications() {
    fetch('Dashboard.php?action=fetch_notifications')
    .then(res => res.json())
    .then(data => {
        const notifications = data.notifications || [];
        const total = data.total || 0;

        // Update badge
        notifBadge.textContent = total;

        // Fill panel
        notificationsList.innerHTML = '';
        notifications.forEach(notif => {
            const li = document.createElement('li');
            li.textContent = notif.message; // Make sure 'message' matches your DB column
            notificationsList.appendChild(li);
        });
    })
    .catch(err => console.error('Error fetching notifications:', err));
}

// Initial load
fetchNotifications();

// Refresh every 10 seconds
setInterval(fetchNotifications, 10000);
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const animationOverlay = document.getElementById('dashboard-animation');
            const animationProgress = document.getElementById('animation-progress');
            const animationText = document.getElementById('animation-text');
            const animationLogo = document.querySelector('.animation-logo');
            
            setTimeout(() => {
            animationLogo.style.opacity = '1';
            animationLogo.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
            animationText.style.opacity = '1';
            }, 600);
            
            setTimeout(() => {
            animationProgress.style.width = '180%';
            }, 100);
            
            setTimeout(() => {
            animationOverlay.style.opacity = '0';
            setTimeout(() => {
                animationOverlay.style.display = 'none';
            }, 500);
            }, 3000);
        });
        
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id);
            const arrow = document.querySelector(`#${id}`).previousElementSibling.querySelector('.dropdown-arrow');
            
            submenu.classList.toggle('active');
            arrow.classList.toggle('rotated');
        }
        
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                this.classList.add('active');
            });
        });
        
        document.querySelectorAll('.submenu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.submenu-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                this.classList.add('active');
            });
        });
        
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = themeToggle.querySelector('i');
        const themeText = themeToggle.querySelector('span');
        
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                themeIcon.className = 'bx bx-sun';
                themeText.textContent = 'Light Mode';
            } else {
                themeIcon.className = 'bx bx-moon';
                themeText.textContent = 'Dark Mode';
            }
        });
        
        window.addEventListener('load', function() {
            const bars = document.querySelectorAll('.chart-bar-value');
            bars.forEach(bar => {
                const height = bar.style.height;
                bar.style.height = '0%';
                setTimeout(() => {
                    bar.style.height = height;
                }, 300);
            });
        });
        
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        function updateTime() {
            const now = new Date();
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const gmt8 = new Date(utc + (8 * 3600000));
            
            const hours = gmt8.getHours().toString().padStart(2, '0');
            const minutes = gmt8.getMinutes().toString().padStart(2, '0');
            const seconds = gmt8.getSeconds().toString().padStart(2, '0');
            
            const timeString = `${hours}:${minutes}:${seconds} UTC+8`;
            document.getElementById('current-time').textContent = timeString;
        }
        
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>