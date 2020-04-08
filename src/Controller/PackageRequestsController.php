<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PackageRequests Controller
 *
 * @property \App\Model\Table\PackageRequestsTable $PackageRequests
 *
 * @method \App\Model\Entity\PackageRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PackageRequestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Packages', 'Users'],
        ];
        $packageRequests = $this->paginate($this->PackageRequests);
        // pr($packageRequests);die();
        $this->set(compact('packageRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Package Request id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $packageRequest = $this->PackageRequests->get($id, [
            'contain' => ['Packages', 'Users'],
        ]);

        $this->set('packageRequest', $packageRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $packageRequest = $this->PackageRequests->newEntity();
        $this->request->data['user_id'] = $this->Auth->User('id');
        if ($this->request->is('post')) {
            $packageRequest = $this->PackageRequests->patchEntity($packageRequest, $this->request->getData());
            if ($this->PackageRequests->save($packageRequest)) {
                $this->Flash->success(__('The package request has been saved.'));

                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
            $this->Flash->error(__('The package request could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Package Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $packageRequest = $this->PackageRequests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $packageRequest = $this->PackageRequests->patchEntity($packageRequest, $this->request->getData());
            if ($this->PackageRequests->save($packageRequest)) {
                $this->Flash->success(__('The package request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The package request could not be saved. Please, try again.'));
        }
        $packages = $this->PackageRequests->Packages->find('list', ['limit' => 200]);
        $users = $this->PackageRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('packageRequest', 'packages', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Package Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $packageRequest = $this->PackageRequests->get($id);
        if ($this->PackageRequests->delete($packageRequest)) {
            $this->Flash->success(__('The package request has been deleted.'));
        } else {
            $this->Flash->error(__('The package request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function sendCode ($package_id, $user_id, $pr_id) {
        $this->autoRender = false;
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $string_shuffled = str_shuffle($string);
        $password = substr($string_shuffled, 1, 6);
        $password = base64_encode($password);
        $pr = $this->PackageRequests->get($pr_id);
        if ($this->request->is('post')) {
            $data = [
                'user_id' => $user_id,
                'package_id' => $package_id,
                'activation_code' => $password
            ];

            $user_package = $this->PackageRequests->UserPackages->newEntity($data);
            if ($this->PackageRequests->UserPackages->save($user_package)) {
                $pr->status = "Completed";
                $this->PackageRequests->save($pr);
                $this->Flash->success(__('Activation code sent'));
                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
        }
    }
}
