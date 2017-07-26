<?php 

namespace App\Model\Table;

use Cake\ORM\Table;

class AppointmentsTable extends Table
{
	public function initialize(array $config)
    {
		// Bind Patient relation 
		$this->belongsTo('Patient', [
		    'className' => 'Users',
		    'foreignKey' => 'patient_id',
		    'propertyName' => 'patient'
		]);

		// Bind Doctor relation 
		$this->belongsTo('Doctor', [
		    'className' => 'Users',
		    'foreignKey' => 'doctor_id',
		    'propertyName' => 'doctor'
		]);
	}


	




}