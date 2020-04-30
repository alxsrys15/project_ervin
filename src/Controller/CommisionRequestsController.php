<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CommisionRequests Controller
 *
 * @property \App\Model\Table\CommisionRequestsTable $CommisionRequests
 *
 * @method \App\Model\Entity\CommisionRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommisionRequestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $commisionRequests = $this->paginate($this->CommisionRequests);

        $this->set(compact('commisionRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Commision Request id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $commisionRequest = $this->CommisionRequests->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('commisionRequest', $commisionRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $commisionRequest = $this->CommisionRequests->newEntity();
        if ($this->request->is('post')) {
            $commisionRequest = $this->CommisionRequests->patchEntity($commisionRequest, $this->request->getData());
            if ($this->CommisionRequests->save($commisionRequest)) {
                $this->Flash->success(__('The commision request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commision request could not be saved. Please, try again.'));
        }
        $users = $this->CommisionRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('commisionRequest', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Commision Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $commisionRequest = $this->CommisionRequests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $commisionRequest = $this->CommisionRequests->patchEntity($commisionRequest, $this->request->getData());
            if ($this->CommisionRequests->save($commisionRequest)) {
                $this->Flash->success(__('The commision request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commision request could not be saved. Please, try again.'));
        }
        $users = $this->CommisionRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('commisionRequest', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Commision Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $commisionRequest = $this->CommisionRequests->get($id);
        if ($this->CommisionRequests->delete($commisionRequest)) {
            $this->Flash->success(__('The commision request has been deleted.'));
        } else {
            $this->Flash->error(__('The commision request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
