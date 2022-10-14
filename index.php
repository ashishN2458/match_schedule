<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Badve Group</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<link href="css/styles.css" rel="stylesheet">
		  <script>
function getteamA(val) {
	//alert(val);
	$.ajax({
	type: "POST",
	url: "getteamA.php",
	data:'coutrycode='+val,
	success: function(data){
		$("#teamB").html(data);
	}
	});
}

</script>	

	</head>
	<body>

<div class="container-fluid">
  <div class="col-sm-8">
    <div class="row">
      <div class="col-xs-12">
        <h3> Cricket Match Schedule</h3>
		<form name="match" id="match">
			  <div id="message" style="color: green;"></div>
			  <div class="form-group">
				<label for="team_a">Team A:</label>
					<select onChange="getteamA(this.value);"  name="teamA" id="teamA" class="form-control" >
							<option value="">Team A</option>
							<?php 
								$query =mysqli_query($conn,"SELECT * FROM country");
								while($row=mysqli_fetch_array($query)){ 
							?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['countryname'];?></option>
							<?php
							}
							?>
						</select>
			  </div>
			  
			
			<div class="form-group">
				<label for="team_a">Team B:</label>
					<select name="teamB" id="teamB" class="form-control" >
						<option value="">Team B</option>
					</select>
			  </div>
			  
			
			<div class="form-group">
					<label for="date">Date Schedule:</label>
					 <input type="text" name="date" id="date" class="form-control datepicker" autocomplete="off">
			</div>
			
			<div class="form-group">
				<input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg btn-block btn-signup-clr" value="Sign Up">
			</div>
			
		</form>
 
      </div>
    </div>
  </div>
</div>

	
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

<script type="text/javascript">
   
$('.datepicker').datepicker({ 
	startDate: new Date()
});
  
  
function formValidation(){	
	
	var data = $("#match").serialize();
	//var baseUrl = window.location.origin;
	console.log("data", data);
		$.ajax({
			//url: baseUrl + "/hiringpark.php",
			url: "submitData.php",
			type: "POST",
			data : data,
			cache: false,
			success: function(response){
				var arr = JSON.parse(response);
				var id = arr.id;
				var teamA = arr.teamA;
				var teamB = arr.teamB;
				var date = arr.date;
				
				var errdataArr = arr.msg;
				var showmessageWPN = "";
				jQuery("#message").hide();
				if(errdataArr){
					for(var index =0; index < errdataArr.length; index++){ 
						var obj = errdataArr[index]; 
						if(obj["status"] === "success" ){
							var message = JSON.stringify(obj["message"]);
							var messageObj = message.replace(/"/g,"");
							showmessageWPN += "<p>" + messageObj + "</p>";
						}
						if(obj["status"] === "failed" ){
							var message = JSON.stringify(obj["message"]);
							var messageObj = message.replace(/"/g,"");
							showmessageWPN += "<p>" + messageObj + "</p>";   
						}
					}
					if(errdataArr.length > 0){																																																																																											
						jQuery("#message").html(showmessageWPN);
						jQuery("#message").show();
						setTimeout(function() { 
							$('#message').fadeOut('fast');
							$("#match")[0].reset();
						
						}, 2000);
					}
					
				}
			}
		});
}

$(document).ready(function() {

	$('#submit').on('click', function(event) { 
	event.preventDefault();
		formValidation();
		//event.preventDefault();
	});
});
</script>
</html>