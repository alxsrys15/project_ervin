<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;
use Ahc\Jwt\JWT;
use Cake\Auth\DefaultPasswordHasher;
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
        $this->Auth->allow(['register', 'resetpassword']);
    }

    public function index()
    {
        $query = $this->Users->find('all')
            ->where(['user_level_id' => 2]);
            // ->order(['created' => 'DESC']);
        $users = $this->paginate($query);
        // pr($users);die();
        $packages = $this->Users->Packages->find('list');

        $this->set(compact('users', 'packages'));
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
    }

    public function activateUser () {
        if ($this->request->is('post')) {
            $user_id = !empty($this->request->data['user_id']) ? $this->request->data['user_id'] : '';
            if (!empty($user_id)) {
                $user = $this->Users->get($user_id);
                $user->status = "Active";
                $user->package_id = $this->request->data['package_id'];
                $user->date_activated = date('Y-m-d H:i:s');
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('User activated'));
                }
            }
        }
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $user_id = $this->Auth->User('id');
        $user = $this->Users->get($user_id);

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
                if ($user['status'] === "Active") {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error('Account inactive');
                }
            } else {
                $this->Flash->error('Incorrect Login');
            }
            return $this->redirect(['action' => 'login']);
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
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            
            if (!empty($this->request->data['ref_link'])) {
                $ref = $jwt->decode($this->request->data['ref_link']);
                $this->request->data['referred_by'] = $ref['id'];
            }

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
            $user = [];
            $query = $this->Users->find('all', [ // query to check if existing yung email sa users table
                'conditions' => [
                    'email' => $this->request->data['Users']['email']
                ]
            ]);

            if ($query->first()) {// kunin yun first result if exisiting yun email
                $user = $query->first()->toArray(); // lipat sa var and convert to array form (toArray())
                $user = $this->Users->get($user['id']); // get yun user data
                $user = $this->__generatePasswordToken($user); // function mo to generate token
                if ($this->Users->save($user) && $this->__sendForgotPasswordEmail($user['id'])) {
                    $this->Flash->success('Password reset instructions have been sent to your email address. You have 24 hours to complete the request.');
                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $this->Flash->error('Sorry, the username entered was not found');
                return $this->redirect(['action' => 'resetpassword']);
            }

            // if (empty($user)) {
            //     $this->Session->setflash('Sorry, the username entered was not found.');
            //     return $this->redirect(['action' => 'resetpassword']);
            // } else {
            //     $user = $this->__generatePasswordToken($user);
            //     if ($this->User->save($user) && $this->__sendForgotPasswordEmail($user['User']['id'])) {
            //         $this->Session->setflash('Password reset instructions have been sent to your email address.
            //             You have 24 hours to complete the request.');
            //          return $this->redirect(['action' => 'login']);
            //     }
            // }
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

        $user['reset_password_token'] = $hash;
        $user['token_created_at']     = date('Y-m-d H:i:s');

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

    public function getReferrals () {
        $user_id = !isset($this->request->data['user_id']) ? $this->Auth->User('id') : $this->request->data['user_id'];

        $user = $this->Users->get($this->Auth->User('id'));

        $query = $this->Users->find('all', [
            'conditions' => [
                'referred_by' => $user_id
            ]
        ]);
        // pr($query);die();
        $referrals = $this->paginate($query);

        $this->set(compact('referrals', 'user'));

    }

    public function changePassword () {
        $user_id = $this->Auth->User('id');
        $user = $this->Users->get($user_id);
        $hasher = new DefaultPasswordHasher;
        if ($this->request->is('post')) {
            $old_password = $hasher->hash($this->request->data['old_password']);
            // pr($old_password);
            // pr($user->password);die();
            if ($old_password === $user->password) {
                $user->password = $old_password;
                if ($this->Users->save($user)) {
                    $this->Flash->success('Password changed');
                }
            } else {
                $this->Flash->error('Incorrect Password');
            }   
        }
    }

}
