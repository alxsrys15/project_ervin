<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PayoutRequests Controller
 *
 * @property \App\Model\Table\PayoutRequestsTable $PayoutRequests
 *
 * @method \App\Model\Entity\PayoutRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayoutRequestsController extends AppController
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
        $payoutRequests = $this->paginate($this->PayoutRequests);

        $this->set(compact('payoutRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Payout Request id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payoutRequest = $this->PayoutRequests->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('payoutRequest', $payoutRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payoutRequest = $this->PayoutRequests->newEntity();
        $prev_sunday_stamp = strtotime('previous sunday');
        $prev_sunday = date('Y-m-d', $prev_sunday_stamp);
        $week_start = date('Y-m-d', strtotime('-6 days', strtotime($prev_sunday)));

        $start_date = $week_start . ' 00:00:00';
        $end_date = $prev_sunday . ' 23:59:59';
        if ($this->request->is('post')) {
            $checker = $this->PayoutRequests->find('all', [
                'conditions' => [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'user_id' => $this->Auth->User('id')
                ]
            ]);
            if ($checker->count() > 0) {
                $this->Flash->error(__('You have already requested payout.'));
                return $this->redirect(['controller' => 'Home','action' => 'index']);
            }
            $payoutRequest = $this->PayoutRequests->patchEntity($payoutRequest, $this->request->getData());
            $payoutRequest->user_id = $this->Auth->User('id');
            $payoutRequest->status = 'Pending';
            $payoutRequest->start_date = $start_date;
            $payoutRequest->end_date = $end_date;
            if ($this->PayoutRequests->save($payoutRequest)) {
                $this->Flash->success(__('The payout request has been saved.'));

                return $this->redirect(['controller' => 'Home','action' => 'index']);
            }
            $this->Flash->error(__('The payout request could not be saved. Please, try again.'));
        }
        $users = $this->PayoutRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('payoutRequest', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payout Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payoutRequest = $this->PayoutRequests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payoutRequest = $this->PayoutRequests->patchEntity($payoutRequest, $this->request->getData());
            if ($this->PayoutRequests->save($payoutRequest)) {
                $this->Flash->success(__('The payout request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payout request could not be saved. Please, try again.'));
        }
        $users = $this->PayoutRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('payoutRequest', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payout Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payoutRequest = $this->PayoutRequests->get($id);
        if ($this->PayoutRequests->delete($payoutRequest)) {
            $this->Flash->success(__('The payout request has been deleted.'));
        } else {
            $this->Flash->error(__('The payout request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getRequests () {
        $requests = $this->PayoutRequests->find('all', [
            'contain' => [
                'Users'
            ]
        ]);
        $requests = $this->paginate($requests);
        // pr($requests);die();
        $this->set(compact('requests'));
    }

    public function referralPayout(){
        $this->loadModel('Users');

        $prev_sunday_stamp = strtotime('previous sunday');
        $prev_sunday = date('Y-m-d', $prev_sunday_stamp);
        $week_start = date('Y-m-d', strtotime('-6 days', strtotime($prev_sunday)));

        $start_date = $week_start . ' 00:00:00';
        $end_date = $prev_sunday . ' 23:59:59';
        //First level referral
        $referralFirst = [];
        $query = $this->Users->find('all') 
            ->where(['status' => 'Active'])
            ->where(function ($q) use ($start_date, $end_date) {
                 return $q->between('date_activated', $start_date, $end_date);
            })
            ->where(['referred_by' => $this->Auth->User('id')]);
        
        $referralFirst = $query->count();
        $referralFirstIds = [];
         
        foreach ($query as $referrals) {
            $referralFirstIds[] = $referrals->id;
        }
        
       // Second level referral
        if(!empty($referralFirstIds)){
            $referralSecond = [];
            $query = $this->Users->find('all') 
                ->where(['status' => 'Active'])
                ->where(function ($q) use ($start_date, $end_date) {
                    return $q->between('date_activated', $start_date, $end_date);
                })
                ->where(['referred_by IN' => $referralFirstIds]);
            $referralSecond = $query->count();
            $referralSecondIds = [];

            foreach ($query as $referrals) {
                $referralSecondIds[] = $referrals->id;
            }
        }else{
            $referralSecond = 0;
        }
        //Third level referral
        if(!empty($referralSecondIds)){
           $referralThird = [];
            $query = $this->Users->find('all') 
                ->where(['status' => 'Active'])
                ->where(function ($q) use ($start_date, $end_date) {
                     return $q->between('date_activated', $start_date, $end_date);
                })
                ->where(['referred_by IN' => $referralSecondIds]);
            $referralThird = $query->count();
            $referralThirdIds = [];

            foreach ($query as $referrals) {
                $referralThirdIds[] = $referrals->id;
            }
        }else{
            $referralThird = 0;
        }
        $user = $this->Users->get($this->Auth->User('id'), [
         'contain' => ['Package']
        ]);

      
        //Compute the referral payout
        $first =  ($user->package->referral_multiplier) * $referralFirst;
        $second = ($user->package->referral_multiplier * .5) * $referralSecond;
        $third = ($user->package->referral_multiplier *.25) * $referralThird;
        $total = $first + $second + $third;
        

       $this->set(compact('referralFirst', $referralFirst));
       $this->set(compact('referralSecond', $referralSecond));
       $this->set(compact('referralThird', $referralThird));
       $this->set(compact('total', $total));
    }

    public function changeStatus () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $return = [
                'success' => false
            ];
            $request = $this->PayoutRequests->get($this->request->data['request_id']);
            $request->status = $this->request->data['status'];
            if ($this->PayoutRequests->save($request)) {
                $return['success'] = true;
            }

            echo json_encode($return);
        }
    }
}
