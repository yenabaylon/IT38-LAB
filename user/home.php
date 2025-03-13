<?php
session_start();
require_once "../db/config.php";
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $id = $_SESSION['id']; // Getting user ID from the session
} else {
    echo "No username found in session.";
    exit; // Exit if the user is not logged in
}

// Include the database connection file

// Insert the attendance if the button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['present'])) {
        // Prepare SQL query to insert attendance
        $sql = "INSERT INTO tbl_attendance (user_id) VALUES (:user_id)";
        
        // Prepare the statement
        if ($stmt = $pdo->prepare($sql)) {
            // Bind the user ID to the query
            $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('You are marked as present!');</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }

            // Close the statement
            unset($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!--Navbar-->
    <nav class="navbar" style="background-color: rgba(1, 1, 49, 0.938);">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Greeting message -->
        <h3>Hello, <?php echo $username; ?>!</h3>
        
        <!-- Form to mark present -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <button type="submit" name="present" class="btn btn-primary w-100">Say Present</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>