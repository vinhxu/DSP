<html>
  <head>
    <script type="text/javascript">

      function myFunction(element) {
        element.style.color = 'red';
        document.getElementById("hiddenInput").value = element.id;
        document.getElementById("inputFileForm").submit();
        //console.log(element.id); 
      }
    </script>
    <style>
    </style>
  </head>

  <body>

    <div id="start">
      <form action="index.php" method="post">
          <h3> AUDIO RECORD </h3>
          <input type="submit" name="Start" value="Start">
          <input type="submit" name="Stop"  value="Stop">
          <br><br>
          <h3> STEPPER MOTOR CONTROL </h3>
          Input RPM:
          <input type="number" name="RPM" min="10" max="100" step="10" value="">
          <input type="submit" name="RunStepper"  value="Run stepper">
          <input type="submit" name="StopStepper"  value="Stop stepper">  
          <br><br>
          <h3> RECORD STEPPER MOTOR SOUND AT DIFFRENT SPEED (RPM) </h3>
          Lower Limit speed:
          <input type="number" name="lowerLimit" min="10" max="100" value=""><br><br>
          Upper Limit speed:
          <input type="number" name="upperLimit" min="10" max="100" value=""><br><br>
          Increment speed:
          <input type="number" name="increment"  min="1"  max="10"  value=""><br><br>
          <input type="submit" name="autoRecord" value="Auto Record"><br><br>
          <?php 
            
              if($_POST['Start']){      //Start collect charging data
                $command = escapeshellcmd('sudo python /var/www/scripts/arecord.py');
                $output = shell_exec($command);
              }elseif ($_POST['Stop']){ //Stop collect charging data
                $command = escapeshellcmd("sudo /var/www/scripts/stop.sh");
                $output = shell_exec($command);
              }elseif ($_POST['RunStepper']){ //Stop collect charging data
                  if(!empty($_POST["RPM"])){
                    $command = escapeshellcmd("sudo python /var/www/scripts/stepper.py ".$_POST["RPM"]);
                    $output = shell_exec($command);
                  }else{
                    echo "RPM required";
                  }      
              }elseif ($_POST['StopStepper']){ //Stop collect charging data
                $command = escapeshellcmd("sudo /var/www/scripts/stopStepper.sh");
                $output = shell_exec($command);
              }elseif ($_POST['autoRecord']){ //Stop collect charging data
                if (empty($_POST["lowerLimit"]) or empty($_POST["upperLimit"]) or empty($_POST["increment"])) {
                  echo "Empty field(s) not allowed <br>";
                  if($_POST['lowerLimit'] > $_POST['upperLimit']){
                    echo "Lower limit must be smaller than upper limit <br>"; 
                  }
                }
                
                $command = escapeshellcmd("sudo /var/www/scripts/stopStepper.sh");
                $output = shell_exec($command);
              } 
            
          ?>
      </form>
    </div>


    
    <div id="inputFile">
      <form id="inputFileForm" action="index.php" method="post">
        <input id="hiddenInput" type="hidden" name="upfile"><br>
        <input                  type="submit" value="Play latest record">
        
        <?php
          //Scan files directory and display all files 
          $dir    = '/var/www/files';
          $files = scandir($dir);
          for ($i = 4; $i <= sizeof($files); $i++) {
            echo "<div id='$files[$i]' class='files' onclick='myFunction(this)'>$files[$i]</div> ";
          }    

          if($_POST['upfile']){      //
            $command = escapeshellcmd("sudo python /var/www/scripts/aplay.py ".$_POST["upfile"]);
            $output = shell_exec($command);
          }

        ?>
      </form>
    </div>

    <div id="chart"></div>

  </body>



</html>
