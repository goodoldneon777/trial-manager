<?php

	function create_info($writeType, $pageType, $seq = null) {
		include(SERVER_ROOT . '/module/info/dist/c_createInput.php');

		$server = getenv('server');
		$userWR = getenv('userWR');
		$passWR = getenv('passWR');
		$db = getenv('db');


		if ($pageType === 'trial') {
			$notFoundMsg = "Trial not found";
			$moduleClass = "m_info panel panel-primary";
			$moduleTitle = "Trial Info";
		} else if ($pageType === 'group') {
			$notFoundMsg = "Group not found";
			$moduleClass = "m_info panel panel-info";
			$moduleTitle = "Group Info";
		}


		// If there's a trial/group to display, query the trial/group info.
		if ($seq !== null) {
			// Create connection
			$conn = new mysqli($server, $userWR, $passWR, $db);
			// Check connection
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			} 


			if ($pageType === 'trial') {
				$sql = "
					select 
						name, start_dt, end_dt, proc_chg_num, twi_num, owner,
						unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, 
						caster_num, strand_num, comment_goal, comment_monitor, 
						comment_general, comment_conclusion
					from trial
					where trial_seq = " . $seq . " 
					";
			} else if ($pageType === 'group') {
				$sql = "
					select 
						name, start_dt, end_dt, owner,
						unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, 
						caster_num, strand_num, comment_goal, comment_monitor, 
						comment_general, comment_conclusion
					from trial_group
					where group_seq = " . $seq . " 
					";
			}

			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();

				$name = $row["name"];
				$startDate = date_format(date_create($row["start_dt"]), "n/j/Y G:i");
				$endDate = date_format(date_create($row["end_dt"]), "n/j/Y G:i");
				$processChange = $row["proc_chg_num"];
				$twi = $row["twi_num"];
				$owner = $row["owner"];
				$unit = $row["unit"];
				$goalType = $row["goal_type"];
				$changeType = $row["change_type"];
				$bopVsl = $row["bop_vsl"];
				$degasVsl = $row["degas_vsl"];
				$argonNum = $row["argon_station"];
				$casterNum = $row["caster_num"];
				$strandNum = $row["strand_num"];
				$goalText = $row["comment_goal"];
				$monitorText = $row["comment_monitor"];
				$otherInfoText = $row["comment_general"];
				$conclusionText = $row["comment_conclusion"];

			} else {
				$html = '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true" style="font-size:15em;"></span>';
				if ($pageType === 'trial') {
					$html .= "<h1>" . $notFoundMsg . "</h1>";
				} else if ($pageType === 'group') {
					$html .= "<h1>" . $notFoundMsg . "</h1>";
				}

				echo $html;

				return;
			}
		} else {
			$name = "";
			$startDate = "";
			$endDate = "";
			$processChange = "";
			$twi = "";
			$owner = "";
			$unit = "";
			$goalType = "";
			$changeType = "";
			$bopVsl = "";
			$degasVsl = "";
			$argonNum = "";
			$casterNum = "";
			$strandNum = "";
			$goalText = "";
			$monitorText = "";
			$otherInfoText = "";
			$conclusionText = "";
		}


  	if ($seq) {
			$html_header =
				'<div class="page-header">' . 
					'<h1>' . $name . '</h1>' .
				'</div>';
		} else {
			$html_header = '';
		}


		$html_name = create_option('name', $name, $writeType);
		$html_startDate = create_option('start_dt', $startDate, $writeType);
		$html_endDate = create_option('end_dt', $endDate, $writeType);
	  $html_unit = create_option('unit', $unit, $writeType);
		$html_owner = create_option('owner', $owner, $writeType);
		$html_processChange = create_option('proc_chg_num', $processChange, $writeType);
		$html_twi = create_option('twi_num', $twi, $writeType);
	  $html_goalType = create_option('goal_type', $goalType, $writeType);
	  $html_changeType = create_option('change_type', $changeType, $writeType);
	  $html_bopVsl = create_option('bop_vsl', $bopVsl, $writeType);
	  $html_degasVsl = create_option('degas_vsl', $degasVsl, $writeType);
	  $html_argonNum = create_option('argon_num', $argonNum, $writeType);
	  $html_casterNum = create_option('caster_num', $casterNum, $writeType);
	  $html_strandNum = create_option('strand_num', $strandNum, $writeType);
	  $html_strandNum = create_option('strand_num', $strandNum, $writeType);
	  $html_goalText = create_option('comment_goal', $goalText, $writeType);
	  $html_monitorText = create_option('comment_monitor', $monitorText, $writeType);
	  $html_otherInfoText = create_option('comment_general', $otherInfoText, $writeType);
	  $html_conclusionText = create_option('comment_conclusion', $conclusionText, $writeType);

?>




<?php echo $html_header; ?>

<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/info/dist/style.min.css"; ?>">


<div class="container noPad-xs">

	<div class="<?php echo $moduleClass; ?>">
		<div class="panel-heading">
	    <h3 class="panel-title"><?php echo $moduleTitle; ?><span class="description"></span>
	    </h3>
	  </div>


	  <div class="container form-inline noPad-xs">

			<div class="row noPad-xs" style="margin:0;">


				<?php
					if ($writeType === 'write') {
						//Continues...
				?>
				<div class="col-sm-2 fullPad-sm halfPad-xs"></div>
				<div class="col-sm-8 fullPad-sm halfPad-xs">
					<div class="name input-group required">
						<?php echo $html_name; ?>
					</div>
    		</div>
    		<div class="col-sm-2 fullPad-sm halfPad-xs"></div>
				<?php
					}
				?>



		  	<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="startDate input-group required">
			    	<?php echo $html_startDate; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="endDate input-group required">
			    	<?php echo $html_endDate; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group required">
			    	<?php echo $html_unit; ?>
					</div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="owner input-group required">
			    	<?php echo $html_owner; ?>
				  </div>
				</div>



				<?php
					if ($pageType === 'trial') {
						//Continues...
				?>
			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="processChange input-group">
			    	<?php echo $html_processChange; ?>
				  </div>
				</div>
				
				
			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="twi input-group">
			    	<?php echo $html_twi; ?>
				  </div>
				</div>
				<?php
					}
				?>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="goalType input-group">
			    	<?php echo $html_goalType; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="changeType input-group">
			    	<?php echo $html_changeType; ?>
				  </div>
				</div>

			</div>


			<!-- Horizontal break line -->
			<div class="col-xs-12"><hr></div>



			<div class="row noPad-xs" style="margin:0;">

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
					<div class="bopVsl input-group">
			    	<?php echo $html_bopVsl; ?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="degasVsl input-group">
			    	<?php echo $html_degasVsl; ?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="argonNum input-group">
			    	<?php echo $html_argonNum; ?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="casterNum input-group">
			    	<?php echo $html_casterNum; ?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="strandNum input-group">
			    	<?php echo $html_strandNum; ?>
				  </div>
				</div>

			</div>

				<!-- Horizontal break line -->
				<div class="col-xs-12"><hr></div>

			<div class="row noPad-xs" style="margin:0;">

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="goalText input-group">
            <?php echo $html_goalText; ?>
            <?php echo $html_goalText2; ?>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="monitorText input-group">
            <?php echo $html_monitorText; ?>
          </div>
        </div>

      </div>



      <div class="row noPad-xs" style="margin:0;">

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="otherInfoText input-group">
            <?php echo $html_otherInfoText; ?>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="conclusionText input-group">
            <?php echo $html_conclusionText; ?>
          </div>
        </div>

			</div>

		</div>

	</div>


</div>


<script src="<?php echo WEB_ROOT . "/module/info/dist/script.min.js"; ?>"></script>



<?php


	}


	

?>






