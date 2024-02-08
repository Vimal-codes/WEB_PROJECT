<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/style1.css" />
    <link rel="stylesheet" href="../css/style3.css" />
    <title>User Registration</title>
</head>
<body>
    <header>
        <div class="hero">
          <nav>
            <img src="../img/IMG_2054.PNG" class="logo">
            <ul>
              <li><a href="one.html">Home</a></li>
              <li><a href="achievements.html">Achievements</a></li>
              <li><a href="gallery.html">Gallery</a></li>
              <li><a href="reg.html">Registration</a></li>
              <li><a href="contact.html">Contact</a></li>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </nav>
        </div>
      </header>
      <div class="success-message">
        <?php
        // Display success message if set
        if (isset($registrationSuccessMessage)) {
            echo $registrationSuccessMessage;
        }
        ?>
    </div>

    <form class="form" action="" method="POST" id="registration-form">
        <h2>Event Registration</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="rollno">Roll no:</label>
        <input type="text" id="rollno" name="rollno" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="gender">Gender:</label>
        <div class="gender-options">
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" value="female" required>
            <label for="female">Female</label>
        </div>

        <label for="event">Choose Event:</label>
        <select id="event" name="event" required>
            <option value="" disabled selected>Select an event</option>
            <option value="badminton">Badminton</option>
            <option value="cricket">Cricket</option>
            <option value="football">Football</option>
            <option value="basketball">Basketball</option>
        </select>

        <label for="department">Department:</label>
        <select type="department" id="department" name="department" required>
            <option value="" disabled selected>Select an department</option>
            <option value="ASC">ASC</option>
            <option value="ASAS">ASAS</option>
            <option value="ASE">ASE</option>
        </select>

        <label for="year">Year:</label>
        <select type="year" id="year" name="year" required>
            <option value="" disabled selected>Select a year</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
        </select>
        <button type="submit" >Register</button> 
    </form>
    <div class="popup" id="popup">
        <img src="../img/404-tick.png">
        <h2>Thank You!</h2>
        <p>Your details has been successfully submitted. Thanks!</p>
        <button type="button" onclick="closePopup()">OK</button>
    </div>
    <footer>
        <p>&copy; 2023 Amrita arena. All rights reserved.</p>
    </footer>
    <script>
        // Define openPopup function
        function openPopup() {
            document.getElementById("popup").classList.add("open-popup");
        }

        // Define closePopup function
        function closePopup() {
            document.getElementById("popup").classList.remove("open-popup");
            window.location.reload(); // Refresh the page when the popup is closed
        }

        // Handle form submission with AJAX
        document.getElementById("registration-form").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            // Serialize the form data
            var formData = $(this).serialize();

            // Submit the form using AJAX
            $.ajax({
                type: "POST",
                url: "reg.php",
                data: formData,
                success: function (response) {
                    console.log(response); // Log the response from the server
                    openPopup(); // Open the popup
                    setTimeout(closePopup, 3000); // Close the popup after 3 seconds
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error: " + textStatus, errorThrown); // Log any AJAX errors
                }
            });
        });
    </script>
</body>
</html>

<?php
// Initialize the success message variable
$registrationSuccessMessage = 'Registration successful';

// Check if the form is submitted via AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "userreg";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate form data (example, you should use prepared statements to prevent SQL injection)
        $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
        $rollno = isset($_POST['rollno']) ? $conn->real_escape_string($_POST['rollno']) : '';
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
        $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
        $event = isset($_POST['event']) ? $conn->real_escape_string($_POST['event']) : '';
        $department = isset($_POST['department']) ? $conn->real_escape_string($_POST['department']) : '';
        $year = isset($_POST['year']) ? $conn->real_escape_string($_POST['year']) : '';

        // Insert data into the database
        $sql = "INSERT INTO registrations (name, rollno, email, gender, event, department, year) 
        VALUES ('$name', '$rollno', '$email', '$gender', '$event', '$department', '$year')";

        if ($conn->query($sql) === TRUE) {
            // Set success message
            $registrationSuccessMessage = "Registration successful";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>



