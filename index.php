<!DOCTYPE html>
<html>
<head>
  <title>HTMX with PHP</title>
  <script src="https://unpkg.com/htmx.org@1.6.0"></script>
</head>
<body>
  <h1>Welcome to HTMX with PHP!</h1>
  
  <button hx-get="/increment">Increment</button>
  <p id="counter"><?php echo $count ?? 0; ?></p>
 
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_HX_REQUEST'])) {
    $count = isset($_POST['count']) ? intval($_POST['count']) : 0;
    $count++;
    echo $count;
  }
  ?>
</body>
</html>
