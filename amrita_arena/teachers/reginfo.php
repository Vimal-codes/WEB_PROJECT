<?php
    require_once("./config/db.php");

    function validate($input) {
        global $con; // Assuming $con is your database connection
        // Sanitize and validate the input
        $validated_input = mysqli_real_escape_string($con, $input);
        return $validated_input;
    }


    // Check if the delete request is received
    if(isset($_GET['chest_no'])){
        $chest_no = $_GET['chest_no'];
        $delete = mysqli_query($con,"DELETE FROM `registrations` WHERE `chest_no`='$chest_no'");
        
        // Redirect to the same page to refresh the data
        header("Location: reginfo.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the 'event' is set in the $_POST array
        if(isset($_POST['event']) && $_POST['event'] != ''){
            $event = validate($_POST['event']);
            
            // Check if the 'gender' is set in the $_POST array
            $gender = isset($_POST['gender']) ? validate($_POST['gender']) : '';

            // Modify the SQL query to include the gender filter
            $genderFilter = ($gender != '') ? "AND gender='$gender'" : "";
            $enquires = mysqli_query($con, "SELECT * FROM registrations 
                                            WHERE event='$event' 
                                            $genderFilter
                                            ORDER BY chest_no DESC");
        } elseif(isset($_POST['gender']) && $_POST['gender'] != ''){
            // If only gender is selected
            $gender = validate($_POST['gender']);
            $enquires = mysqli_query($con, "SELECT * FROM registrations 
                                            WHERE gender='$gender' 
                                            ORDER BY chest_no DESC");
        } else {
            // If the form is not submitted or only events are selected, display all records
            $enquires = mysqli_query($con, "SELECT * FROM registrations ORDER BY chest_no DESC");
        }
    } else {
        // If the form is not submitted, display all records
        $enquires = mysqli_query($con, "SELECT * FROM registrations ORDER BY chest_no DESC");
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tstyle.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Registered Information</title>
    <style>
        section {
            padding: 20px;
            background-color: #ffffff;
            margin: 10px;
            border-radius: 5px;
        }

        h2 {
            color: rgb(177, 15, 86);
        }

        p {
            color: #333333;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-dark">
    <header>
        <div class="hero">
          <nav>
            <img src="../img/IMG_2054.PNG" class="logo">
            <ul>
              <li><a href="./teacher.html">Home</a></li>
              <li><a href="./Tachievements.html">Achievements</a></li>
              <li><a href="./Tgallery.html">Gallery</a></li>
              <li><a href="./reginfo.php">Registered info</a></li>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </nav>
        </div>
    </header>
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card">
                    <div class="class-header">
                        <h2 class="display-6 text center">Registered Information</h2>
                    </div>
                    <div class="col-md-5">
                        <h4>Students List</h4>
                    </div>
                    <div class="col-md-7">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="event" class="form-select">
                                        <option value="" disabled selected>Select an event</option>
                                        <option value="badminton" <?php echo (isset($_POST['event']) && $_POST['event'] == 'badminton') ? 'selected' : ''; ?>>Badminton</option>
                                        <option value="cricket" <?php echo (isset($_POST['event']) && $_POST['event'] == 'cricket') ? 'selected' : ''; ?>>Cricket</option>
                                        <option value="football" <?php echo (isset($_POST['event']) && $_POST['event'] == 'football') ? 'selected' : ''; ?>>Football</option>
                                        <option value="basketball" <?php echo (isset($_POST['event']) && $_POST['event'] == 'basketball') ? 'selected' : ''; ?>>Basketball</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="gender" class="form-select">
                                        <option value="" disabled selected>Select a gender</option>
                                        <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="reginfo.php" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class="bg-dark text-white">
                                <td>Chest no</td>
                                <td>Name</td>
                                <td>Roll no</td>
                                <td>Email</td>
                                <td>Gender</td>
                                <td>Event</td>
                                <td>Department</td>
                                <td>Year</td>
                                <td>Delete</td>
                            </tr>
                            <?php 
                                while($row=mysqli_fetch_assoc($enquires)) {
                                    $ChestNo = $row['chest_no'];
                                    $Name = $row['name'];
                                    $RollNo = $row['rollno'];
                                    $Email = $row['email'];
                                    $Gender = $row['gender'];
                                    $Event = $row['event'];
                                    $Department = $row['department'];
                                    $Year = $row['year'];
                            ?>
                                <tr>
                                    <td><?php echo $ChestNo ?></td>
                                    <td><?php echo $Name ?></td>
                                    <td><?php echo $RollNo ?></td>
                                    <td><?php echo $Email ?></td>
                                    <td><?php echo $Gender ?></td>
                                    <td><?php echo $Event ?></td>
                                    <td><?php echo $Department ?></td>
                                    <td><?php echo $Year ?></td>
                                    <td><a href="reginfo.php?chest_no=<?php echo $ChestNo; ?>" class="btn btn-danger">Delete</a></td>
                                </tr>        
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
