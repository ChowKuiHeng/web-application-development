<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="dropdown">
            <h3>What is your date of birth?</h3>
            <button class="btn btn-primary dropdown-toggle" type="button" id="daydropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Day
            </button>
            <ul class="dropdown-menu" aria-labelledby="daydropdown">
                <?php for ($i = 1; $i <= 31; $i++) { ?>
                    <li><a class="dropdown-item" href="#"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
            <button class="btn btn-warning dropdown-toggle" type="button" id="monthdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Month
            </button>
            <ul class="dropdown-menu" aria-labelledby="monthdropdown">
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                    <li><a class="dropdown-item" href="#"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
            <button class="btn btn-danger dropdown-toggle" type="button" id="yeardropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Year
            </button>
            <ul class="dropdown-menu" aria-labelledby="yeardropdown">
                <?php for ($i = 1900; $i <= 2023; $i++) { ?>
                    <li><a class="dropdown-item" href="#"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</body>

</html>