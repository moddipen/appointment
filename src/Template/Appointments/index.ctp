<!-- Include Datatable JS and CSS file -->
<?php 
	
use Cake\Core\Configure;

	echo $this->Html->css('jquery.dataTables.min');
	echo $this->Html->script('jquery.dataTables.min');
?>

<div class="users form">
	<?php  
		if($this->request->session()->read('Auth.User.usertype') == 0) {?>
			<div>
				<a href="<?php echo Configure::read('SITE_URL').'appointments/add' ?>" class="button">Add Appointment</a>
			</div>
	<?php } ?>		
	<?= $this->Flash->render() ?>
	<p>
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Appointment Date</th>
					<th>Doctor</th>
					<th>Patient</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Id</th>
					<th>Appointment Date</th>
					<th>Doctor</th>
					<th>Patient</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
			<tbody>
				<?php 
					if (!empty($Appointment))
					{

						foreach($Appointment as $appointment) { ?>
						<tr>
							<td><?= $appointment->id ?></td>
							<td><?= $appointment->appointment_date ?></td>
							<td><?= $appointment->doctor_id ?></td>
							<td><?= $appointment->patient_id ?></td>
							<td><?php if ($appointment->status == 0) { echo "Pending" ; } else if($appointment->status == 1) { echo "Confirm" ;} else { echo "Postpone" ;}?></td>
							<td><?php 
									if ($appointment->status == 0) {
									echo $this->Html->link('Confirm','/appointments/confirm/'.$appointment->id,['class'=>'button','confirm' => 'Are you want to confirm']);
									echo $this->Html->link('Postpone','/appointments/postpone/'.$appointment->id,['class'=>'button','confirm' => 'Are you want to postpone']);			
									}
									echo $this->Html->link('Delete','/appointments/delete/'.$appointment->id,['class'=>'button','confirm' => 'Are you want to delete']);
												
							 ?></td>
						</tr>
				<?php } 
					}?>	
			</tbody>
		</table>
	</p>
</div>
<script>
	$(document).ready(function(){
	    $('#example').DataTable({
	    	'order':false
	    });
	});
</script>