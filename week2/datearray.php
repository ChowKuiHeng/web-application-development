<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Date Array</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h3>What is your date of birth?</h3>
            <div class="col">
                <select class="form-select form-select-lg bg-primary">
                    <option selected>Day</option>
                    <?php for ($day = 1; $day <= 31; $day++) { ?>
                        <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col">
                <select class="form-select form-select-lg bg-warning">
                    <option selected>Month</option>

                    <?php
                    $monthname = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    for ($m = 0; $m <= 11; $m++) {
                        echo "<option value=\"$monthname\">$monthname[$m]</option>";
                    }
                    ?>

                </select>
            </div>
            <div class="col">
                <select class="form-select form-select-lg bg-danger">
                    <option selected>Year</option>
                    <?php for ($year = 1900; $year <= 2023; $year++) { ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</body>

</html>