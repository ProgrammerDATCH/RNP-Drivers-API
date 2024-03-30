<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNP - Driver Registration</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5 text-center">
        <h2>Register New Driver</h2>

        <div class="row">
            <div class="col-10 col-md-6 mx-auto">
                <form id="driverForm" method="POST" action="regist-driver.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Driver Name</label>
                        <input type="text" class="form-control" id="name" name="names" required>
                    </div>
                    <div class="form-group">
                        <label for="license">License Number</label>
                        <input type="text" class="form-control" id="license" oninput="formatLicenseID(this)" name="license" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="floatingSelect">License Category</label>
                        <select class="form-control" name="license_category" id="floatingSelect">
                        <option value="a">Category A</option>
                        <option value="b">Category B</option>
                        <option value="c">Category C</option>
                        <option value="d">Category D</option>
                        <option value="e">Category E</option>
                        <option value="f">Category F</option>
                        <option value="g">Category G</option>
                        <option value="h">Category H</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="img" class="form-label">Choose image of a Driver</label>
                        <input type="file" id="img" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" class="form-control" aria-label="file example" required>
                    </div>


                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>


        <h2 class="mt-5">Registered Drivers</h2>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Driver Image</th>
                            <th>Driver Name</th>
                            <th>License Number</th>
                            <th>License Category</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody id="driverList">
                        <?php
                            include_once 'db.php';
                            $sql = "SELECT * FROM drivers;";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) 
                            {
                                echo "<tr>";
                                echo "<td><img src='driver_images/" . $row['driver_image'] . "' style='border-radius: 50%; width: 50px;' /></td>";
                                echo "<td>" . $row['names'] . "</td>";
                                echo "<td>" . $row['license'] . "</td>";
                                echo "<td>" . $row['license_category'] . "</td>";
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
            function formatLicenseID(input, data) {
            var inputValue = input.value.replace(/[^\d]/g, "");
            if(data)
            {
                inputValue = data
            }
            var formatPattern = "- ---- - ------- - --";
            var formattedValue = "";

            for (var i = 0, j = 0; i < formatPattern.length; i++) {
                if (formatPattern[i] === " ") {
                    formattedValue += " ";
                }
                else {
                    if (inputValue[j]) {
                        formattedValue += inputValue[j];
                        j++;
                    }
                    else {
                        if (i === 0 && formattedValue.length === 0) {
                            formattedValue += "-";
                        } else {
                            formattedValue += "-";
                        }
                    }
                }
            }
            input.value = formattedValue;
        }

        document.getElementById("license").addEventListener("keydown", function (e) {
        if (e.key === "Backspace") {
            e.preventDefault();
            var input = e.target;
            var formattedValue = input.value.replace(/[^\d]/g, "");

            let stop = false;
            for (let i = formattedValue.length - 1; stop === false; i--) {
                if (formattedValue[i] !== "-" && formattedValue[i] !== " ") {
                    formattedValue = formattedValue.slice(0, -1);
                    stop = true;
                }
            }

            formatLicenseID(input, formattedValue);
        }
    });
    </script>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>