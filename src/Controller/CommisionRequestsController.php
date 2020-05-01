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
        $commisionRequests = $this->paginate($this->CommisionRequests, ['limit' => 10]);

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
            $this->request->data['user_id'] = $this->Auth->User('id');
            $commisionRequest = $this->CommisionRequests->patchEntity($commisionRequest, $this->request->getData());
            $checker = $this->CommisionRequests->find('all')
                ->where(['user_id' => $this->Auth->User('id')])
                ->where(['date_start' => $this->request->getData('date_start')])
                ->where(['date_end' => $this->request->getData('date_end')]);
            if ($checker->count() > 0) {
                $this->Flash->error(__('You already requested for this payout'));
                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
            if ($this->CommisionRequests->save($commisionRequest)) {
                $this->Flash->success(__('The commision request has been saved.'));

                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
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

    public function getCommissions () {
        $user_id = $this->Auth->User('id');
        if (empty($this->request->data['date'])) {
            $date = date('Y-m-d', strtotime('wednesday this week'));
            if (strtotime('today') > strtotime('wednesday this week') && strtotime('today') < strtotime('sunday this week')) {
                $date = date('Y-m-d', strtotime('sunday this week'));
                $end_date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
                $start_date = date('Y-m-d', strtotime('-3 days', strtotime($end_date)));
                $multiplier = 4;
            } else {
                $end_date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
                $start_date = date('Y-m-d', strtotime('-2 days', strtotime($end_date)));
                 $multiplier = 3;
            }
        } else {
            $date = $this->request->data['date'];
            if (strtotime($date) == strtotime('wednesday this week', strtotime($date))) {
                $end_date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
                $start_date = date('Y-m-d', strtotime('-2 days', strtotime($end_date)));
                $multiplier = 3;
            } else {
                $end_date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
                $start_date = date('Y-m-d', strtotime('-3 days', strtotime($end_date)));
                $multiplier = 4;
            }
        }
        
        $divider = .25 / 7;

        $first_entry = $this->CommisionRequests->Users->UserInvestments->find('all')
            ->where(['user_id' => $this->Auth->User('id')])
            ->where(['is_active' => 1]);

        $query = $this->CommisionRequests->Users->UserInvestments->find('all')
            ->where(['user_id' => $user_id])
            ->where(['is_active' => 1])
            /* ->where(function ($q) use($start_date) {
                return $q->gte('date', $start_date);
            }) */;

        

        $total = 0;

        foreach ($query as $i_record) {
            $total += $i_record->amount;
        }

        $total_commission = $total * ($divider * $multiplier);

        $investments = $this->paginate($query, ['limit' => 10]);

        if ($first_entry->first()) {
            $first_entry = $first_entry->first();
            $first_date = $first_entry->date->format('Y-m-d');
            if (strtotime($end_date) < strtotime($first_date)) {
                $investments = [];
                $total = 0;
                $total_commission = 0;
            }
            // $query->where(function ($q) use ($first_date) {
            //     return $q->gte('date', $first_date->format('Y-m-d'));
            // });

            // pr($query);

        }

        $this->set(compact('investments', 'start_date', 'end_date', 'total', 'total_commission'));
    }

    public function changeStatus () {
        $this->autoRender = false;
        $return = [
            'success' => false
        ];
        if ($this->request->is('post')) {
            $request = $this->CommisionRequests->get($this->request->data['request_id']);
            $request->status = $this->request->data['status'];
            if ($this->CommisionRequests->save($request)) {
                $return = [
                    'success' => true
                ];
            }
        }
        echo json_encode($return);
    }

    public function getReports () {
        $requests = $this->CommisionRequests->find('all', [
            'conditions' => [
                'user_id' => $this->Auth->User('id')
            ]
        ]);
        $requests = $this->paginate($requests, ['limit' => 10]);
        // pr($requests);die();
        $this->set(compact('requests'));
    }
}
