<?php
session_start();

include "../config/db.php";

$user = $_SESSION['id'];

if (!$user) {
    header('location: ../index.php');
    exit();
}

$fetch = "SELECT * FROM `admins` WHERE `admin_id` = ?";
$stmt = $connect->prepare($fetch);
$stmt->bind_param('s', $user);
$stmt->execute();
$result = $stmt->get_result();
$fetch_admin = $result->fetch_assoc();

// Pagination settings
$reviews_per_page = 5; // Number of reviews per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page (default: 1)
$offset = ($page - 1) * $reviews_per_page; // Calculate offset

// Fetch total number of reviews
$total_query = "SELECT COUNT(*) as total FROM `feedbacks`";
$total_result = $connect->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_reviews = $total_row['total'];
$total_pages = ceil($total_reviews / $reviews_per_page); // Total pages

// Fetch reviews for the current page
$reviews_query = "SELECT * FROM `feedbacks` ORDER BY `feedback_id` DESC LIMIT ? OFFSET ?";
$stmt = $connect->prepare($reviews_query);
$stmt->bind_param('ii', $reviews_per_page, $offset);
$stmt->execute();
$reviews_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Feedback System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <nav class="bg-indigo-600 text-white p-4 flex justify-between items-center shadow-md">
        <div class="text-xl font-bold">Admin Dashboard</div>
        <div class="flex items-center space-x-4">
            <span class="hidden sm:inline uppercase">Welcome, <?php echo htmlspecialchars($fetch_admin['name']); ?></span>
            <form action="../includes/logout.php" method='POST'>
              <button type="submit" name="logout_btn" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
            </form>

            <a href="add-admin.php" class="bg-slate-500 hover:bg-slate-600 px-3 py-1 rounded text-sm">Add Admin</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">User Feedbacks</h1>
            
            <!-- Reviews Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full text-left">
                    <thead class="bg-indigo-500 text-white">
                        <tr>
                            <th class="p-4 text-sm font-semibold">ID</th>
                            <th class="p-4 text-sm font-semibold">User</th>
                            <th class="p-4 text-sm font-semibold">Rating</th>
                            <th class="p-4 text-sm font-semibold">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($reviews_result->num_rows > 0): ?>
                            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 text-sm text-gray-700"><?php echo htmlspecialchars($review['feedback_id']); ?></td>
                                    <td class="p-4 text-sm text-gray-700"><?php echo htmlspecialchars($review['name']); ?></td>
                                    <td class="p-4 text-sm text-gray-700"><?php echo htmlspecialchars($review['rating']); ?>/5</td>
                                    <td class="p-4 text-sm text-gray-700"><?php echo htmlspecialchars($review['comment']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">No feedbacks found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-6 flex justify-center items-center space-x-2">
                    <!-- Previous Button -->
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Previous</a>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed">Previous</span>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="px-3 py-1 rounded <?php echo $i === $page ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Next Button -->
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Next</a>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed">Next</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        <p class="text-sm">© <?php echo date('Y'); ?> User Feedback System. All rights reserved.</p>
    </footer>
</body>
</html>