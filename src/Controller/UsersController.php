<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow(['register']);
    }

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    // Login
    public function login(){
        $this->layout = 'login';
        if($this->request->is('post')){
            $user = $this->Auth->identify();

            if($user){
                $this->Auth->setUser($user);
                return $this->redirect(['action' => 'index']);
            }
            // Bad Login
            $this->Flash->error('Incorrect Login');
        }
    }
    public function logout()
    {
        $this->Flash->success('You are now logged out.');
         return $this->redirect(['action' => 'login']);
    }

    public function appsettings(){
        $this->loadModel('AppSettings');
        $appSetting = $this->AppSettings->get('1');

        if($this->request->is(['post', 'put'])){
            $appSetting = $this->AppSettings->patchEntity($appSetting, $this->request->getData());
            if($this->AppSettings->save($appSetting)){
                $this->Flash->success('Successfully updated!');
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Error updating!');
            }
        }
        $this->set('referral_value', $appSetting->referral_value);
        $this->set('captcha_value', $appSetting->referral_value);
        $this->set('appsettings', $appSetting);
    }

    // public function beforeFilter(Event $event){
    //     $this->Auth->allow(['register']);
    // }

    public function register () {
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $user = $this->Users->newEntity($data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Registration success. Please wait for account activation');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Something went wrong');
        }
    }
   public function resetpassword() {
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $user = $this->User->findByUsername($this->data(['Users']['username']));
            if (empty($user)) {
                $this->Session->setflash('Sorry, the username entered was not found.');
                 return $this->redirect(['action' => 'resetpassword']);
            } else {
                pr($user);
                die();
                $user = $this->__generatePasswordToken($user);
                if ($this->User->save($user) && $this->__sendForgotPasswordEmail($user['User']['id'])) {
                    $this->Session->setflash('Password reset instructions have been sent to your email address.
                        You have 24 hours to complete the request.');
                     return $this->redirect(['action' => 'login']);
                }
            }
        }
    }
     function __generatePasswordToken($user) {
        if (empty($user)) {
            return null;
        }

        // Generate a random string 100 chars in length.
        $token = "";
        for ($i = 0; $i < 100; $i++) {
            $d = rand(1, 100000) % 2;
            $d ? $token .= chr(rand(33,79)) : $token .= chr(rand(80,126));
        }

        (rand(1, 100000) % 2) ? $token = strrev($token) : $token = $token;

        // Generate hash of random string
        $hash = Security::hash($token, '', true);;
        for ($i = 0; $i < 20; $i++) {
            $hash = Security::hash($hash, '', true);
        }

        // $user['User']['reset_password_token'] = $hash;
        // $user['User']['token_created_at']     = date('Y-m-d H:i:s');

        return $user;
    }

    /**
     * Validate token created at time.
     * @param String $token_created_at
     * @return Boolean
     */
    function __validToken($token_created_at) {
        $expired = strtotime($token_created_at) + 86400;
        $time = strtotime("now");
        if ($time < $expired) {
            return true;
        }
        return false;
    }

    /**
     * Sends password reset email to user's email address.
     * @param $id
     * @return
     */
    function __sendForgotPasswordEmail($id = null) {
        if (!empty($id)) {
            $this->User->id = $id;
            $User = $this->User->read();

            $this->Email->to        = ['Users']['email'];
            $this->Email->subject   = 'Password Reset Request - DO NOT REPLY';
            $this->Email->replyTo   = 'do-not-reply@example.com';
            $this->Email->from      = 'Do Not Reply <do-not-reply@example.com>';
            $this->Email->template  = 'reset_password_request';
            $this->Email->sendAs    = 'both';
            $this->set('Users', $User);
            $this->Email->send();

            return true;
        }
        return false;
    }

    /**
     * Notifies user their password has changed.
     * @param $id
     * @return
     */
    function __sendPasswordChangedEmail($id = null) {
        if (!empty($id)) {
            $this->User->id = $id;
            $User = $this->User->read();

            $this->Email->to        = $User['User']['email'];
            $this->Email->subject   = 'Password Changed - DO NOT REPLY';
            $this->Email->replyTo   = 'do-not-reply@example.com';
            $this->Email->from      = 'Do Not Reply <do-not-reply@example.com>';
            $this->Email->template  = 'password_reset_success';
            $this->Email->sendAs    = 'both';
            $this->set('User', $User);
            $this->Email->send();

            return true;
        }
        return false;
    }

}
