<?php
session_start();

// Database connection
// Replace with your actual database credentials
$con = mysqli_connect("localhost", "root", "", "aqi");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch unique countries from INFO table
$sql = "SELECT DISTINCT country FROM INFO ORDER BY country ASC";
$result = mysqli_query($con, $sql);

$countries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $countries[] = $row['country'];
}

// Check if user is logged in, otherwise redirect
if (isset($_SESSION['user'])) {
    // Welcome message and logout button will be rendered in HTML
} else {
    header("Location: index.html");
    exit();
}
    
// Handle form submission
$error = "";
$selected = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is for submitting countries or clearing them
    if (isset($_POST['submit_countries'])) {
        $selected = isset($_POST['countries']) ? $_POST['countries'] : [];
        if (count($selected) != 10) {
            $error = "Please select 10 Countries.";
        } else {
            $_SESSION['selected_countries'] = $selected;
            header("Location: showaqi.php");
            exit();
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select 10 Countries</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif; 
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5px;
            
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
        }
        .welcome-message {
            font-size: 1.25rem;
            color: #333;
            margin: 0;
            text-align: left;
            flex-grow: 1;
        }
        .logout-button {
            padding: 8px 12px;
            background-color: #ef4444; 
            color: white;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .logout-button:hover {
            background-color: #dc2626;
        }
        h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .checkbox-grid {
            display: grid;
            gap: 5px;
            margin-bottom: 10px;
            text-align: left;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            padding: 5px;
        }
        .checkbox-label input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
            accent-color: #3b82f6; 
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .submit-button {
            padding: 8px 12px;
            background-color: #22c55e; 
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }
        .clear-button {
            padding: 8px 12px;
            background-color: #ef4444; 
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }
        .error-message {
            color: #ef4444;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h3 class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['user']['Name']); ?></h3>
            <!-- Logout button -->
            <button class="logout-button" onclick="window.location.href='logout.php'">LOGOUT</button>
        </div>

        <h2>Select 10 Countries for AQI</h2>
        <form method="post" id="countryForm">
            <div class="checkbox-grid" id="country-checkboxes">
                <?php foreach ($countries as $country): ?>
                    <label class="checkbox-label">
                        <input type="checkbox" name="countries[]" value="<?php echo htmlspecialchars($country); ?>"
                            <?php if (in_array($country, $selected)) echo 'checked'; ?>>
                        <?php echo htmlspecialchars($country); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            
            <div class="button-group">
                <button type="submit" name="submit_countries" class="submit-button">Submit</button>
                <button type="button" id="clearSelection" class="clear-button">Clear Selection</button>
            </div>
        </form>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('#country-checkboxes input[type="checkbox"]');
        const clearButton = document.getElementById('clearSelection');

        // Function to update checkbox disabled state
        function updateCheckboxState() {
            const checked = document.querySelectorAll('#country-checkboxes input[type="checkbox"]:checked');
            if (checked.length >= 10) {
                checkboxes.forEach(box => {
                    if (!box.checked) {
                        box.disabled = true;
                    }
                });
            } else {
                checkboxes.forEach(box => {
                    box.disabled = false;
                });
            }
        }

        // Add event listeners to all checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCheckboxState);
        });

        // Add event listener for the Clear Selection button
        if (clearButton) {
            clearButton.addEventListener('click', function() {
                checkboxes.forEach(box => {
                    box.checked = false; // Uncheck all checkboxes
                    box.disabled = false; // Re-enable all checkboxes
                });
                // After clearing, re-run the state update in case any were still disabled (e.g., if 10 were checked then cleared)
                updateCheckboxState(); 
            });
        }

        // Initial check on page load to set correct disabled states
        updateCheckboxState();
    });
    </script>
</body>
</html>