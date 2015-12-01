<div id="m-create-info" class="panel panel-primary">
	<div class="panel-heading">
    <h3 class="panel-title">
    	Trial Information
    	<span class="description">(only 1st row is required)</span>
    </h3>
  </div>

	<!-- <form class="bs-create bs-create-form" role="form"> -->

	<div class="row form-inline">
	  <div class="trial-name input-group">
    	<span class="elem-title required">Trial Name</span>
    	<input class="form-control" type="text" placeholder="e.g. SP-97 Mold Powder" data-toggle="tooltip" title="Can be the same as a previous trial name. 'Start Date' will differentiate trials with the same name.">
    	<span></span>
	  </div>
	  
	  <div class="user input-group">
    	<span class="elem-title required">User Name</span>
    	<input class="form-control" type="text" placeholder="e.g. HAR4144" data-toggle="tooltip" title="User name for the person managing this trial.">
    	<span></span>
	  </div>

	  <div class="start-date input-group">
    	<span class="elem-title required">Start Date</span>
    	<input class="form-control" type="text" placeholder="e.g. 11/7/2015" data-toggle="tooltip" title="Date this trial started. You may optionally put the time.">
    	<span></span>
	  </div>

	  <div class="end-date input-group">
    	<span class="elem-title required">End Date</span>
    	<input class="form-control" type="text" placeholder="e.g. 11/8/2015" data-toggle="tooltip" title="Date this trial ended. You may optionally put the time.">
    	<span></span>
	  </div>
	</div>


	<br>


	<div class="row form-inline">
	  <div class="proc-chg-num input-group">
    	<span class="elem-title">Process Change #</span>
    	<input class="form-control" type="text" placeholder="" data-toggle="tooltip" title="Process change number.">
    	<span></span>
	  </div>

	  <div class="twi-num input-group">
    	<span class="elem-title">TWI #</span>
    	<input class="form-control" type="text" placeholder="" data-toggle="tooltip" title="Temporary work instruction (TWI) number.">
    	<span></span>
	  </div>

	  <div class="trial-unit form-group">
		  <span class="elem-title">Unit</span>
		  <select class="form-control" data-toggle="tooltip" title="Area where this trial will be performed.">
		    <option></option>
		    <option>BF</option>
		    <option>BOP</option>
		    <option>Degas</option>
		    <option>Argon</option>
		    <option>LMF</option>
		    <option>Caster</option>
		    <option>Other</option>
		  </select>
		</div>

	  <div class="trial-type form-group">
		  <span class="elem-title">Trial Type</span>
		  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial trying to improve?">
		    <option></option>
		    <option>Cost</option>
		    <option>Process</option>
		    <option>Quality</option>
		    <option>Safety</option>
		    <option>Other</option>
		  </select>
		</div>

	  <div class="change-type form-group">
		  <span class="elem-title">Change Type</span>
		  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial changing?">
		    <option></option>
		    <option>Equipment</option>
		    <option>Material</option>
		    <option>Model</option>
		    <option>Procedure</option>
		    <option>Other</option>
		  </select>
		</div>
	</div>



	<div class="row form-inline">
	  <div class="bop-vsl unit-nums form-group">
		  <span class="elem-title">BOP Vsl</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one BOP vessel?">
		    <option></option>
		    <option>25</option>
		    <option>26</option>
		  </select>
		</div>

	  <div class="degas-vsl unit-nums form-group">
		  <span class="elem-title">Degas Vsl</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Degasser vessel?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="argon-num unit-nums form-group">
		  <span class="elem-title">Argon #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Argon station?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="caster-num unit-nums form-group">
		  <span class="elem-title">Caster #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="strand-num unit-nums form-group">
		  <span class="elem-title">Strand #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster strand?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		    <option>3</option>
		    <option>4</option>
		  </select>
		</div>
	</div>


	<br>


	<div class="row form-inline">

		<div class="trial-goal form-group">
		  <span class="elem-title">Desired Results</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Specifically, what is this trial trying to improve?"></textarea>
		</div>

		<div class="trial-monitor form-group align-top">
		  <span class="elem-title">Aspects to Monitor</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Specifically, what must be monitored on this trial?"></textarea>
		</div>

	</div>



	<div class="row form-inline">

		<div class="trial-comment form-group">
		  <span class="elem-title">General Comments</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Any miscellaneous comments about this trial."></textarea>
		</div>

		<div class="trial-conclusion form-group">
		  <span class="elem-title">Conclusions (After Trial Completion)</span>
		  <textarea class="form-control" data-toggle="tooltip" title="What were the results of the trial? Was it successful? Should another trial be performed?"></textarea>
		</div>

	</div>

	
<!-- </form> -->

</div>












