<?php
include '../conn/connection.php'; // Database connection
include 'dashboard_flex.php'; // Include your dashboard layout

// Fetch sales data for daily trends
$sql = "
    SELECT 
        DATE(order_date) AS order_date, 
        SUM(oi.quantity * m.price) AS daily_total
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu m ON oi.item_id = m.item_id
    GROUP BY DATE(order_date)
    ORDER BY DATE(order_date)";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);  // Error handling
}

// Prepare data for daily sales
$salesData = [];
while ($row = $result->fetch_assoc()) {
    $salesData[$row['order_date']] = $row['daily_total'];
}

// Prepare data for chart
$chartLabels = json_encode(array_keys($salesData)); // Dates for x-axis
$chartData = json_encode(array_values($salesData));  // Daily totals for y-axis
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-5">
    <h2>Daily Sales Trends</h2>
    
    <canvas id="salesTrendChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $chartLabels; ?>,
                datasets: [{
                    label: 'Daily Sales',
                    data: <?php echo $chartData; ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
$conn->close();
?>
