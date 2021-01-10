<?php 
include_once('backend.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="main.js" type="text/javascript"></script>
    <title>CSV Generator</title>
</head>
<body>


    <div class="container">

        <h2>CSV Generator</h2>
        <form id="csvgenerator_form" action="index.php" method="post">
            <div class="row">
                <label for="min_value">Start date</label>
                <input type="date" name="start" id="start" value="<?php echo (new DateTime('NOW'))->format("Y-m-d"); ?>">
            </div>
            <div class="row">
                <label for="min_value">End date</label>
                <input type="date" name="end" id="end" value="<?php echo (new DateTime('NOW'))->modify("+1 days")->format("Y-m-d"); ?>">
            </div>
            <div class="row">
                <label for="min_value">Min Value</label>
                <input type="number" name="min_value" id="min_value" min="0" max="999" value="1">
            </div>
            <div class="row">
                <label for="max_value">Max Value</label>
                <input type="number" name="max_value" id="max_value" min="0" max="999" value="100">
            </div>
            <div class="row">
                <input type="submit" value="Generate">
            </div>
        </form>
    </div>

    <div id="output">
    </div>
</body>
</html>