<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <title>Sprint1</title>
  </head>
  <body>
    <h1>Directory contents: <?php echo $_SERVER['REQUEST_URI']; ?></h1>
    <?php

      //$_SERVER['DOCUMENT_ROOT'] === 'C:/Program Files/Ampps/www';    cia matom kur yra visa to serverio pradzia
      //$_SERVER['REQUEST_URI'] === /uzduotis/   cia matom kuris katalogas
      // C:/Program Files/Ampps/www/uzduotis/

      // katalogas
      if (isset($_GET['path'])) {   // cia pasitikrinu kur esu
        $directory = $_GET['path'];   // ar vidiniame?  $_SERVER['REQUEST_URI'] .  . "/". $_GET['path']
        //echo $_SERVER['SCRIPT_FILENAME'] . "/" . $_GET['path'] ; // 
      } else {         //jei ne - tai esu teviniam 'plikam' kataloge
        $directory = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];   // cia visas bendras motininis katalogas
      }
     
      //$content = scandir($directory);
      //echo $directory;                   content - tai pagrindinis failu masyvas (sarasas objektu)
      $content = array_diff(scandir($directory), array('..', '.'));   // issivalau, kad rodytu svaru kelia be taskeliu
      //$directory = array_slice(scandir($directory), 2);
      //
       //print_r($content);
    ?>
    
    <script>
    function goBack() {
      window.history.back();
    }
    </script>

    <?php                                 // bandymas trinti faila
    //if (file_exists($value)) {
        //unlink($value);
        //echo "File:" . $value . "deleted.";
    //}
    ?>

  <table class="table table-striped table-hover">
  <thead style="background-color: lightpink; color:white;">
    <tr>
      <th scope="col">Type</th>
      <th scope="col">Name</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

<?php
    foreach ($content as $value) {
     //echo $value . '<br>';
    if(is_file($value)) {
      echo (
        "
        <tr>
          <td><i class='bi bi-file-earmark-text'></i> File</td>
          <td>$value</td>
          <td>
          <button type='button' class='btn btn-outline-danger btn-sm'><i class='bi bi-trash'></i></button></td>
        </tr>
        "
      );
    } else if(is_dir($value)) {    // nuoroda naudoja path kintamaji, kuris pakeicia direktorijos reiksme. 
      echo ("
      <tr>
      <td><i class='bi bi-folder'></i> Directory</td>
      <td><a href='?path=$value'>$value</a></td> 
      <td></td>
      </tr>
     " 
    );
    } else {      // tiesiog kazkas 
      echo (
        "
        <tr>
          <td>File</td>
          <td>$value</td>
          <td><button type='button' class='btn btn-outline-danger btn-sm'><i class='bi bi-trash'></i></button></td>
        </tr>
        "
      );
    }
  }
?>
  </tbody>
</table>

<?php if(isset($_POST['submit'])): ?>
    <?php $name = $_POST['name']; ?>
    <?php mkdir($name); ?>
    Catalog: <?php echo $name; ?> is created.
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-outline-primary btn-md" onclick="goBack()">Back</button>
        </div>
    
        <div class="col-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">    
            <input type="name" name="name" class="form-control" id="name" placeholder="New directory name">
        </div>
        <div class="col-2">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    
    </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
  </body>
</html>