<?php
include ('../authadminorct.php');
include '../settings.php';
include (dirname(dirname(__FILE__)).'/functions.php');
getheader('Import');
// Script
$error='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["filetoimport"]["name"]);
  $uploadOk = 1;
  $filetype = pathinfo($target_file,PATHINFO_EXTENSION);

  // Check file size
  if ($_FILES["filetoimport"]["size"] > 30000) {
    $error .= "Sorry, your file is too large.<br>";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($filetype != "csv") {
    $error .= "Sorry, only CSV files are allowed.<br>";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $error .= "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {

    $exit = 0;
    $databasetable = "vb_schueler";
    $fieldseparator = ",";
    $lineseparator = "\n";
    $csvfile = $_FILES["filetoimport"]["tmp_name"];


    if (!file_exists($csvfile)) {
      echo "File not found. Make sure you specified the correct path.<br>";
      exit;
    }

    $file = fopen($csvfile,"r");

    if (!$file) {
      echo "Error opening data file.<br>";
      exit;
    }

    $size = filesize($csvfile);

    if (!$size) {
      echo "File is empty.<br>";
      exit;
    }

    $csvcontent = fread($file,$size);

    fclose($file);

    mysqli_select_db($db,$databasename) or die(mysql_error());

    $lines = 0;
    $queries = "";
    $linearray = array();

    foreach(split($lineseparator,$csvcontent) as $line) {

      $lines++;
      $line = trim($line," \t");
      $line = str_replace("\r","",$line);
      $line = str_replace("'","\'",$line);
      $linearray = explode($fieldseparator,$line);

      if ((!isset($linearray[3]))&&(!isset($linearray[1]))) {
        echo 'Please delete line break at the end of the csv file.<br>';
        exit;
      }

      if (!isset($linearray[3])) {
        $linearray[3]='';
      }

      if ((in_array($linearray[3], $RELIGION)) && ($linearray[3] != $RELIGION['subreligion'])) {
        $tmp_rel = array_search($linearray[3], $RELIGION);
        $linearray[3] = $tmp_rel;
      } else {
        $linearray[3] = '';
      }

      // Create defaultmarks
      $defaultmarks = '';
      $start = true;
      for ($i=0; $i < sizeof($SUBJECTS); $i++) {
        if(!$start) {
          $defaultmarks .= ';';
        } else {
          $start = false;
        }
        for ($j=0; $j < sizeof($CATEGORIES); $j++) {
          $defaultmarks .= '0';
        }
      }


      $linemysql = implode("','",$linearray);
      $query = "INSERT INTO $databasetable VALUES('','$linemysql','$defaultmarks');";

      $queries .= $query . "<br>";

      if(mysqli_query($db,$query)) {
      } else {
        echo 'Error writing into database.<br>'. mysqli_error($db) . '<br>';
      }
    }

    $error .= "Found a total of $lines records in this csv file.<br>";
    $error .= $queries;

  }
}


// Body
?>
<div class="grid6_box">
  <div class="grid6_row">
    <div class="grid6_col-6" style="background:#f3f3f3;color:#525252;text-align:center">
      <h3>CSV-Datei importieren</h3>
      <h5>
        Die CSV-Datei sollte folgendes Muster haben:
        <br>
      </h5>
      <pre>
        Vorname,Nachname,Klasse,Konfession*
        Vorname,Nachname,Klasse,Konfession*
      </pre>
      <h5>
        Als Codierung bitte UTF-8 verwenden<br>
        *optional
        <br>
        zulässige Konfessionenen sind:<br>
        <small>!Groß-/Kleinschreibung beachten!</small><br><?php
        foreach ($RELIGION as $k => $v) {
          if ($k == 'subreligion') continue;

          echo $v . '<br>';
        }
        ?>
        Sind die Konfessionen anders eingetragen können sie von Hand geändert werden.<br>
        <span style="color:red;">Vor dem Import die settings.php einstellen</span>
      </h5>
      <div class="container">
        <form enctype="multipart/form-data" action="import.php" method="POST">
          <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
          <input name="filetoimport" type="file" />
          <input type="submit" value="Hochladen" />
        </form>
      </div>
      <h3><?php echo $error;?></h3>
    </div><!--Col-->

  </div><!--Row-->
</div><!--Box-->


<?php
// Footer
mysqli_close($db);
getfooter();
?>
