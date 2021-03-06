<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\Utility\Security;
use Ahc\Jwt\JWT;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;

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
        $this->Auth->allow(['register', 'resetpassword', 'testEmail']);
    }

    public function index()
    {
        $query = $this->Users->find('all', [
            'conditions' => [
                'user_level_id' => 2
            ]
        ]);
        $users = $this->paginate($query, [
            'limit' => 10
        ]);
        $inactiveUser = [];
        $query = $this->Users->find('all',[
            'conditions' => [   
                'status' => 'Active'
            ]
        ]);
        $inactiveUser = $query->count();
        $activeUser = [];
        $query = $this->Users->find('all',[
            'conditions' => [   
                'status' => 'Inactive'
            ]
        ]);
        $activeUser = $query->count();

        
        $packages = $this->Users->Packages->find('list');
        $this->set(compact('inactiveUser', $inactiveUser));
        $this->set(compact('activeUser', $activeUser));
        $this->set(compact('users', 'packages'));
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
    }

    public function activateUser () {
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $string_shuffled = str_shuffle($string);
        $password = substr($string_shuffled, 1, 6);
        $password = base64_encode($password);   
        $id = $this->request->getData('user_id');
        // pr($this->request->data);die();
        $data = [
                'user_id' => $id,
                'activation_code' => $password,
                'package_id' => $this->request->getData('package_id')
            ];
        $this->loadModel('UserPackages');   
        $user_packages = $this->UserPackages->newEntity($data);
        if (!empty($id)) {
            if($this->request->is('post')){
                if($user = $this->UserPackages->save($user_packages)){
                    // $email = new Email();
                    // $email
                    //     ->template('otp_password_request', 'default')
                    //     ->subject('OTP Code Request - DO NOT REPLY')
                    //     ->emailFormat('html')
                    //     ->setViewVars(['user' => $user,
                    //                    'password' => $password])
                    //     ->from('activation@captcha.ph')
                    //     ->to($user->email)
                    //     ->send();
                    $this->Flash->success(__('The user package has been saved.'));
                    return $this->redirect(['controller' => 'Home', 'action' => 'index']);
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
    public function edit()
    {
        $id = $this->Auth->User('id');
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile updated'));

                return $this->redirect(['action' => 'view']);
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
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Incorrect Login');
            }
            return $this->redirect(['action' => 'login']);
        }
    }
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
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
        $jwt = new JWT('secret', 'HS256', 86400, 10);
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $ref = '';
            if (!empty($this->request->data['ref_link'])) {
                $payload = explode('.', $this->request->data['ref_link']);
                $ref = json_decode(base64_decode($payload[1]), true);
                // try {
                //     $ref = $jwt->decode($this->request->data['ref_link']);
                // } catch (\Exception $e) {
                //     echo 'expired link';
                // }
            }

            $user = $this->Users->patchEntity($user, $data);
            $user->referred_by = !empty($ref) ? $ref['id'] : null;
            // pr($user);die();
            if ($this->Users->save($user)) {
                $this->Flash->success('Registration success. Please wait for account activation');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Something went wrong');
        }

        $this->set(compact('jwt'));
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
        $id = $this->request->getData('user_id');
        if (!empty($id)) {
            $user = $this->Users->get($id);
            $email = new Email();
            $email
                ->template('reset_password_request', 'default')
                ->subject('OTP Code Request - DO NOT REPLY')
                ->emailFormat('html')
                ->setViewVars(['user' => $user,
                               'password' => $password])
                ->from('activation@captcha.ph')
                ->to($user->email)
                ->send();

            return true;
        }
        return false;
    }


    public function getReferrals () {
        $user_id = !isset($this->request->data['user_id']) ? $this->Auth->User('id') : $this->request->data['user_id'];

        $user = $this->Users->get($this->Auth->User('id'));

        $query = $this->Users->find('all', [
            'conditions' => [
                'referred_by' => $user_id,
                'status' => 'Active'
            ]
        ]);
        // pr($query);die();
        $referrals = $this->paginate($query, ['limit' => 10]);

        $this->set(compact('referrals', 'user'));

    }

    public function changePassword () {
        $user_id = $this->Auth->User('id');
        $user = $this->Users->get($user_id);
        $hasher = new DefaultPasswordHasher;
        if ($this->request->is('post')) {
            $pass_check = $hasher->check($this->request->data['old_password'], $user->password);
            if ($pass_check) {
                $user->password = $this->request->data['new_password'];
                if ($this->Users->save($user)) {
                    unset($this->request->data['old_password']);
                    unset($this->request->data['new_password']);
                    unset($this->request->data['confirm_password']);
                    $this->Flash->success('Password changed');
                }
            } else {
                $this->Flash->error('Incorrect Password');
            }   
        }
    }
    public function newpassword()
    {
        return $this->redirect(['action' => 'resetpassword']);
    }

    public function getPackages () {
        $user_id = $this->Auth->User('id');
        if ($user_id) {
            $user_packages = $this->Users->UserPackages->find('all', [
                'conditions' => [
                    'user_id' => $user_id
                ],
                'contain' => [
                    'Packages'
                ]
            ]);

            $packages = $this->Users->Packages->find('list', [
                'conditions' => [
                    'is_active' => 1
                ]
            ]);

            $user_packages = $this->paginate($user_packages, ['limit' => 10]);
            // pr($user_packages);die();
            // pr($user_packages);die();

            $this->set(compact('packages', 'user_packages'));
        }
    }

    public function selfActivation () {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $user = $this->Users->get($this->Auth->User('id'));
            if ($user->status === "Active") {
                $this->Flash->error(__('Account already activated'));
                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
            $query = $this->Users->UserPackages->find('all', [
                'conditions' => [
                    'activation_code' => $data['activation_code']
                ]
            ]);
            $user_package = [];
            if ($query->first()) {
                $user_package = $query->first();
                if ($user_package->is_used) {
                    $this->Flash->error(__('Invalid activation code'));
                } else {
                    $user->status = "Active";
                    $user->date_activated = date('Y-m-d H:i:s');
                    $user->package_id = $user_package->package_id;
                    $user_package->is_used = 1;
                    $s = $this->Users->save($user);
                    $this->Auth->setUser($s);
                    $this->Users->UserPackages->save($user_package);
                    $this->Flash->success(__('Account activated'));
                }
                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
            
        }
    }

    public function generateReferralLink () {
        $result = [
            'success' => false,
            'token' => ''
        ];
        $this->autoRender = false;
        $user_id = $this->Auth->User('id');
        $user = $this->Users->get($user_id);
        $jwt = new JWT('secret', 'HS256', 86400, 10);
        $token = $jwt->encode([
            'id' => $user_id,
        ]);

        $link = Router::url(['controller' => 'Users', 'action' => 'register', '?' => ['referral' => $token]], true);

        $user->referral_link = $link;
        
        if ($this->Users->save($user)) {
           $result = [
                'success' => true,
                'token' => $link
           ];
        }

        echo json_encode($result);
    }
}
