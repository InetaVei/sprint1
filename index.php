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

<div class="container">
  <div class="row">
    <div class="col-12">
      <form>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>




    <h1>Directory contents: <?php echo $_SERVER['REQUEST_URI']; ?></h1>

    <?php if(isset($_POST['submit'])):  // cia kuriamas katalogas ?>     
      <?php $name = $_POST['name']; ?>
      <?php mkdir($name); ?>
    <?php endif; ?>

    <?php if(isset($_GET['delete'])):   // cia daromas failo trinimas ?>
        <?php unlink($_GET['delete']); ?>
    <?php endif; ?>

    <?php
      if(isset($_GET['download'])) {
        // print('Path to download: '.'./'. $_POST['download']);     // ar reikia $_GET["path"] ???
        $file = './' . $_GET['download'];
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'uft-8'));
        ob_clean();
        ob_start();
        header('Content-Description: File Tra');
        header('Content-Type:' . mime_content_type($fileToDownloadEscaped));
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, prie-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped));
        ob_end_flush();
        readfile($fileToDownloadEscaped);
        exit;
      }
    ?>

    <?php
      if(isset($_FILES['image'])) {
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];  //laikinas [temporary]
        $file_type = $_FILES['image']['type'];

        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
        $extensions = array("jpeg","jpg","png");
        if(in_array($file_ext, $extensions) === false) {
          $errors[]= 'extension not allowed, please choose a JPEG or PNG file';   // KAZKAIP GALIU SU FOR ISPRINTINTI GRAZIAI
        }
        if($file_size > 2097152) {
          $errors[] = 'File size must be smaller than 2 MB';
        }
        if(empty($errors) == true) {
          move_uploaded_file($file_tmp, "./" . $path .  $file_name);   // per cia vyksta failu aploudinimas
          // echo "Success";
        } else {
          print_r($errors);
        }
      }
    ?>

    <?php
    global $dir_path;

    if (isset($_GET["directory"])) {
        $dir_path = $_GET["directory"];
        //echo $dir_path;
    }
    else {
        $dir_path = $_SERVER["DOCUMENT_ROOT"]."/sprint1/";    // nurodomas kur yra serveris - pagrindinis katalogas
    }
    $directories = array_diff(scandir($dir_path), array('..', '.'));    // naudojame scandir bet su array_diff nuimame taskiukus
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
        <?php foreach($directories as $entry): ?>
          <?php if (is_dir($dir_path . "/" . $entry)) : // su pilnu keliu tikrinama ar sis irasas tai kategorija ?>   
            <tr>
              <td><i class='bi bi-folder'></i> Directory</td>
              <td>
                <a href="?directory=<?php echo "" . $dir_path . "" . $entry . "/" ?>">
                  <?php echo $entry; ?>
                </a>
              </td> 
              <td></td>
            </tr>     
          <?php else: ?>
            <tr>
              <td><i class='bi bi-file-earmark-text'></i> File</td>
              <td><?php echo $entry; ?></td>
              <td>
                <a href="?delete=<?php echo $dir_path . $entry; ?>" class="btn btn-outline-danger btn-sm"><i class='bi bi-trash'></i></a>
                <a href="?download=<?php echo $entry; ?>" class="btn btn-outline-success btn-sm"><i class="bi bi-file-earmark-arrow-down"></i></a>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
  </table>

<div class="container-fluid">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-outline-primary btn-md" onclick="goBack()">Back</button>
            <script>
            function goBack() {
              window.history.back();
            }
            </script>
        </div>    
        <div class="col-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">    
            <input type="name" name="name" class="form-control" id="name" placeholder="New directory name">
        </div>
        <div class="col-2">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        <div class="col-6">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="row g-2">
            <div class="col-auto"><input class="form-control" type="file" id="formFile" name="image"></div>
            <div class="col-auto"><button type="submit" name="submit" class="btn btn-primary">Upload</button></div>
          </form>
        </div>
        <br>
        <br>

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