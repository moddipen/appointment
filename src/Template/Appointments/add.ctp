<!-- File: src/Template/Users/login.ctp -->
<?php 
	echo $this->Html->css('jquery.datetimepicker');
	echo $this->Html->script('jquery.datetimepicker.full');
?>

<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
    	<div>
	    	<?php if (!empty($Doctor)) {?>
	        <label>Doctor name :</label>
	        <select name="doctor_id">
	        	<?php foreach ($Doctor as $doctor) {?>
	        		<option value ="<?php echo $doctor->id;?>"><?php echo $doctor->username;?></option>
	        	<?php } ?>
	        </select>	
	        <?php }?>
    	</div>
    	<div>
    		<label> Appointment date</label>
    		<input type="text" class="some_class" name="appointment_date" id="some_class_1"/>
    	</div>	

    </fieldset>
<?= $this->Form->button(__('Add')); ?>
<?= $this->Form->end() ?>
</div>

<script>
	$('.some_class').datetimepicker({
		formatTime:'H:i',
		formatDate:'yyyy-m-d',
		minDate: 0

	});
</script>