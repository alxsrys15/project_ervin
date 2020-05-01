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
 * UserInvestments Controller
 *
 * @property \App\Model\Table\UserInvestmentsTable $UserInvestments
 *
 * @method \App\Model\Entity\UserInvestment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserInvestmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $userInvestments = $this->paginate($this->UserInvestments);

        $this->set(compact('userInvestments'));
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        // $this->Auth->allow(['investments', 'admin_investments']);
    }
    /**
     * View method
     *
     * @param string|null $id User Investment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userInvestment = $this->UserInvestments->get($id, [
            'contain' => [],
        ]);

        $this->set('userInvestment', $userInvestment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
           $this->request->data['user_id'] = $this->Auth->User('id');
           $userInvestment = $this->UserInvestments->newEntity($this->request->getData());
           if ($this->UserInvestments->save($userInvestment)) {
               $this->Flash->success(__('Investment saved. Please wait for approval.'));
               return $this->redirect(['controller' => 'Home', 'action' => 'index']);
           }
        }
        $this->set(compact('userInvestment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Investment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userInvestment = $this->UserInvestments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userInvestment = $this->UserInvestments->patchEntity($userInvestment, $this->request->getData());
            if ($this->UserInvestments->save($userInvestment)) {
                $this->Flash->success(__('The user investment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user investment could not be saved. Please, try again.'));
        }
        $this->set(compact('userInvestment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Investment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userInvestment = $this->UserInvestments->get($id);
        if ($this->UserInvestments->delete($userInvestment)) {
            $this->Flash->success(__('The user investment has been deleted.'));
        } else {
            $this->Flash->error(__('The user investment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function investments(){
        $query = $this->UserInvestments->find('all', [
            'conditions' => [
                'user_id' => $this->Auth->User('id')
            ]
        ]);
        

        $userInvestments = $this->paginate($query, ['limit' => 10]);

        $this->set(compact('userInvestments', 'userInvestments'));
    }
    public function adminInvestments(){

        $userInvestments = $this->UserInvestments->find('all', [
            'contain' => 'Users'
        ]);
        $userInvestments = $this->paginate($userInvestments, ['limit' => 10]);
        $this->set(compact('userInvestments', $userInvestments));
    }
    public function activateInvestment($userinvestment_id){
        if ($this->request->is('post') && $userinvestment_id) {
            $userInvesments = $this->UserInvestments->get($userinvestment_id);
            $userInvesments->is_active = 1;
            $userInvesments->date_approved = date('Y-m-d');
            if ($e = $this->UserInvestments->save($userInvesments)) {
                $this->Flash->success(__('Investment approved'));
            }
        }
        return $this->redirect(['controller' => 'home', 'action' => 'index']);
    }
}
