<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Registration Form</h1>
        <form action="process_registration.php" method="POST">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="mb-3">
                <label for="Day" class="form-label">Date of Birth</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="Day" name="Day" required>
                            <option value="" selected disabled>Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value=\"$day\">$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="Month" name="Month" required>
                            <option value="" selected disabled>Month</option>
                            <?php
                            $months = array(
                                1 => "January",
                                2 => "February",
                                3 => "March",
                                4 => "April",
                                5 => "May",
                                6 => "June",
                                7 => "July",
                                8 => "August",
                                9 => "September",
                                10 => "October",
                                11 => "November",
                                12 => "December"
                            );
                            foreach ($months as $month) {
                                echo "<option value=\"$month\">$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="Year" name="Year" required>
                            <option value="" selected disabled>Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1900; $year <= 2023; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" required>
                    <label class="form-check-label" for="genderMale">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" required>
                    <label class="form-check-label" for="genderFemale">
                        Female
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z_\-][a-zA-Z0-9_\-]{5,}" title="Username must start with a letter, have at least 6 characters, and can only contain letters, numbers, '_', or '-'." required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*[\W_]).{6,}$" title="Password must have at least 6 characters, including 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols are allowed." required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>

</html>