<?php
	/*
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
	*/
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
		<link rel="stylesheet" href="css/bootstrap.min.css">	
		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript">
			
			function myFunction(element) {
				element.style.color = 'red';
				document.getElementById("hiddenInput").value = element.id;
				document.getElementById("inputFileForm").submit();
				//console.log(element.id); 
			}
		</script>
	</head>
	
	<body>
		<div class="orange"><h1>DSP PROJECT</h1></div>
		<div id="start">
			<form action="index.php" method="post">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-lg-4 redbox">
							<img src="img/record.png" alt="record icon" id="recordIcon">
							<h3> AUDIO RECORD </h3>
							<button type="submit" name="Start" value="Start" style="margin-right:25px;">
								<img src="img/record-start.png" alt="start the record" />
							</button>
							<button type="submit" name="Stop"  value="Stop" style="margin-left:25px;">
								<img src="img/record-stop.png" alt="start the record" />
							</button><br>
							<input type="submit" id="recordSubmit">
						</div>
						<div class="col-xs-12 col-sm-8 col-lg-8 bluebox">
							<h3> STEPPER MOTOR CONTROL </h3>
							<img src="img/Stepper.png" alt="Stepper Icon" style="margin-bottom:10px;"/><br>
							Input RPM:
							<input type="number" name="RPM" min="10" max="100" step="10" value=""><br><br>
							
							<input type="submit" name="RunStepper"  value="Run stepper" id="RunStepper">
							<input type="submit" name="StopStepper"  value="Stop stepper" id="StopStepper">  
						</div>
						<div class="col-xs-12 col-sm-8 col-lg-8 purplebox">
							<h3> RECORD STEPPER MOTOR SOUND AT DIFFRENT SPEED (RPM) </h3>
							<img src="img/auto-record.png" alt="auto record" style="margin-bottom:10px;"/><br>
							<div class="col-xs-4 col-sm-4 col-lg-4">
								Lower Limit speed:
								<input type="number" name="lowerLimit" min="10" max="100" value="">
							</div>
							<div class="col-xs-4 col-sm-4 col-lg-4">
								Upper Limit speed:
								<input type="number" name="upperLimit" min="10" max="100" value="">
							</div>
							<div class="col-xs-4 col-sm-4 col-lg-4">
								Increment speed:
								<input type="number" name="increment"  min="1"  max="10"  value="">
							</div><br><br>
							<input type="submit" name="autoRecord" value="Auto Record" id="autoRecord">
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row">		
				<div id="inputFile"  class="col-xs-12 col-sm-12 col-lg-12 greenbox">
					<form id="inputFileForm" action="index.php" method="post">
						<input id="hiddenInput" type="hidden" name="upfile">
						<input                  type="submit" value="Play latest record" id="playLastRecord">
					</form>
				</div>
			</div>
		</div>
		
		<div id="chart"></div>
	</body>
</html>
