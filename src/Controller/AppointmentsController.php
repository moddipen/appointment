<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AppointmentsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        
        // $this->loadModel('Appointments');
    }
    
    /**
     *  Add Appointment from patient  
     *  
     */   
    public function add()
    {
        // Fetch Doctor Deatil
        $Doctor = TableRegistry::get('Users');
        $doctor = $Doctor->find()
                            ->where(['usertype' => 1])
                            ->all();

        $this->set('Doctor',$doctor);                    
    
        if ($this->request->is('post')) {

            $Appointments = TableRegistry::get('Appointments');

            $change_date = date('Y-m-d H:i:s',strtotime($this->request->data['appointment_date'])); 
            $doctor_id = $this->request->data['doctor_id'];

            $this->request->data = $Appointments->newEntity();

            $this->request->data['doctor_id'] =  $doctor_id;
            $this->request->data['appointment_date'] = $change_date;
            $this->request->data['patient_id'] = $this->Auth->user('id');
            $this->request->data['created'] = date('Y-m-d H:i:s');
            $this->request->data['modified'] = date('Y-m-d H:i:s');

            if ($Appointments->save($this->request->data)) {

                // Send Email Notification When Patient create new Appointment     
                $email = new Email('default');
                
                $email->from(['test2@teknomines.com' => 'support@appointment.com'])
                    ->to('bharat.tecknomines@gmail.com')
                    ->subject('New Appointment')
                    ->send('New Appointment is created by Bharat on Date : '.$change_date);

                $this->Flash->success(__('Appointment create successfully'));
            
                return $this->redirect(['action'=>'index']);
            
            } else {

                $this->Flash->error(__('Something went wrong'));
            
                return $this->redirect(['action'=>'index']);
        
            }



        }
    }


    /**
     *  Appointment listing from Doctor or Patient wise   
     *  
     */
    public function index()
    {
        $Appointments = TableRegistry::get('Appointments');    
        // Check login user is doctor
        if ($this->Auth->user('usertype') == 1 ) {
            $appointment = $Appointments->find()
                                    ->where(['doctor_id' => $this->Auth->user('id')])
                                    ->order(['id'=>'DESC'])
                                    //->contain(['Doctor','Patient'])
                                    ->all();
        } else {
            // Fetch patient Appointment list
             $appointment = $Appointments->find()
                                    ->where(['patient_id' => $this->Auth->user('id')])
                                    ->order(['id'=>'DESC'])
                                    //->contain(['Doctor','Patient'])
                                    ->all();
        }

        $this->set('Appointment',$appointment);
    }


    /**
    *   Appointment delete from doctor and patient side
    *   @param : $id is Appoinment id
    */

    public function delete($id = null)
    {
        $this->autoRender = false;

        $entity = $this->Appointments->get($id);
        
        if ($this->Appointments->delete($entity)) {

            $this->Flash->success(__('Appointment delete successfully'));
            
            return $this->redirect(['action'=>'index']);
        
        } else {
            
            $this->Flash->error(__('Unable to delete appointment'));
            
            return $this->redirect(['action'=>'index']);
        }
    } 


    /**
    *   Appointment Confirm from doctor side
    *   @param : $id is Appoinment id
    */

    public function confirm($id = null)
    {
        $this->autoRender = false;

        $tablename = TableRegistry::get("Appointments");
        
        $query = $tablename->query();
                    $result = $query->update()
                            ->set(['status' => 1])
                            ->where(['id' => $id])
                            ->execute();
        
        // Fetch appointment is update or not 
        $appoint = $tablename->get($id);                  

        if ($appoint->status == 1) {

            // Send Email Notification When Doctor confirm Patient Appointment     
            $email = new Email('default');
            
            $email->from(['test2@teknomines.com' => 'support@appointment.com'])
                ->to('bharat.tecknomines@gmail.com')
                ->subject('Confirm Appointment')
                ->send('Appointment is confirmed by doctor');

            $this->Flash->success(__('Appointment confirm successfully'));
            
            return $this->redirect(['action'=>'index']);

        } else {

            $this->Flash->error(__('Something went wrong'));
            
            return $this->redirect(['action'=>'index']);
      
        }
    } 

    /**
    *   Appointment Postpone from doctor side
    *   @param : $id is Appoinment id
    */

    public function postpone($id = null)
    {
        $this->autoRender = false;

        $tablename = TableRegistry::get("Appointments");
        
        $query = $tablename->query();
                    $result = $query->update()
                            ->set(['status' => 2])
                            ->where(['id' => $id])
                            ->execute();
        
        // Fetch appointment is update or not 
        $appoint = $tablename->get($id);                  

        if ($appoint->status == 2) {

            // Send Email Notification When Doctor confirm Patient Appointment     
            $email = new Email('default');
            
            $email->from(['test2@teknomines.com' => 'support@appointment.com'])
                ->to('bharat.tecknomines@gmail.com')
                ->subject('Postpone Appointment')
                ->send('Appointment is postpone by doctor');


            $this->Flash->success(__('Appointment postpone successfully'));
            
            return $this->redirect(['action'=>'index']);

        } else {

            $this->Flash->error(__('Something went wrong'));
            
            return $this->redirect(['action'=>'index']);
      
        }
    }



}
