<?php
require("./includes/constants.php");
require("./includes/forms.php");
require("./includes/functions.php");
require("./includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>salesupdate</title>
</head>
<body>
<a href="salespeople.php">HERE</a> 
    
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        ?>
        <h1>TEST: <?php echo($_POST['inputIsActive']) ?> </h1>
        
        <?php
            //A painful way of getting the last path in
            $url_parsed = parse_url($_SERVER['REQUEST_URI']);
            print_r($url_parsed);
            $id = explode('/', $url_parsed['path']);
            $id = $id[count($id) - 1];
            //alternatives include using query strings for easier access, or using a hidden input for easier access
            
            update_salesperson_activity($id, $_POST['inputIsActive']);
    }
?>