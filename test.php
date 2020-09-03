
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container"> 
  <table class="table table-hover">
    <thead>
      <tr>
        <th>account</th>
        <th>productname</th>
        <th>amount</th>
        <th>price</th>
        <th>orderDate</th>
      </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <td><?php echo $row["account"] ?></td>
            <td><?php echo $row["productname"] ?></td>
            <td><?php echo $row["amount"] ?></td>
            <td><?php echo $row["price"] ?></td>
            <td><?php echo $row["orderDate"] ?></td>
        <td>
        
            <span class="float-right">      
            </span>
        </td>
      </tr>
   <?php }?>   
    </tbody>
  </table>
</div>
</body>
</html>