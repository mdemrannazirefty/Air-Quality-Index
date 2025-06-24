<?php
session_start();

// Database connection 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "aqi"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['final_submit'])) {
    // Store form data in session
    $_SESSION['form_data'] = $_POST;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Review Info</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
            }
            ul {
                list-style-type: none;
                padding: 0;
                text-align: left;
                margin-bottom: 20px;
            }
            li {
                margin-bottom: 10px;
            }
            button {
                padding: 8px 12px;
                border: none;
                color: white;
                cursor: pointer;
                margin: 0 20px;
                font-weight: bold;
            }
            .confirm {
                background-color: #28a745;
            }
            .cancel {
                background-color: #dc3545;
            }
        </style>
    </head>
    <body>
        <div class="review-box">
            <h2>Review Your Information</h2>
            <ul>
                <li><strong>Name:</strong> <?php echo htmlspecialchars($_POST['fname']); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></li>
                <li><strong>Gender:</strong> <?php echo htmlspecialchars($_POST['gender']); ?></li>
                <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($_POST['dob']); ?></li>
                <li><strong>Country:</strong> <?php echo htmlspecialchars($_POST['Country']); ?></li>
                <li><strong>Terms:</strong> <?php echo isset($_POST['terms']) ? "Agreed" : "Not Agreed"; ?></li>
                <li><strong>Opinion:</strong> <?php echo htmlspecialchars($_POST['opinion']); ?></li>
            </ul>
            <form method="post">
                <button class="confirm" type="submit" name="final_submit" value="confirm">Confirm</button>
                <button class="cancel" type="submit" name="final_submit" value="cancel">Cancel</button>
            </form>
        </div>
    </body>
    </html>
    <?php
} elseif (isset($_POST['final_submit'])) {
    if ($_POST['final_submit'] === 'confirm') {
        $data = $_SESSION['form_data'];

        if (isset($data['bgcolor'])) {
            setcookie('aqi_bgcolor', $data['bgcolor'], time() + (86400 * 30), "/");
        }

        $stmt = $conn->prepare("INSERT INTO user (Name, Email, Gender, Dob, Country, Opinion, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "sssssss",
            $data['fname'],
            $data['email'],
            $data['gender'],
            $data['dob'],
            $data['Country'],
            $data['opinion'],
            $data['cpassword']
        );

        if ($stmt->execute()) {
            unset($_SESSION['form_data']);
            session_write_close();
            header("Location: index.html");
            exit();
        } else {
            echo "<p style='color:red;'>Error saving registration: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
        unset($_SESSION['form_data']);
    } else {
        unset($_SESSION['form_data']);
        header("Location: index.html");
        exit();
    }
} else {
    echo "Invalid Request";
}

$conn->close();
?>
