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
        if ($this->request->is('post')) {
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
        $requests = $this->PayoutRequests->find('all');
        $requests = $this->paginate($requests);
        $this->set(compact('requests'));
    }

    public function referralPayout(){
        $this->loadModel('Users');

        $start_date = strtotime('-2 weeks');
        $end_date = strtotime('-1 week');
        //First level referral
        $referralFirst = [];
        $query = $this->Users->find('all') 
            ->where(function ($q) use ($start_date, $end_date) {
                 return $q->between('date_activated', $start_date, $end_date);
            })
            ->where(['referred_by' => $this->Auth->User('id')]);
        
        $referralFirst = $query->count();
        $referralFirstIds = [];
         
        foreach ($query as $referrals) {
            $referralFirstIds = $referrals->id;
        }
        
       // Second level referral
        if(!empty($referralFirstIds)){
            $referralSecond = [];
           $query = $this->Users->find('all') 
            ->where(function ($q) use ($start_date, $end_date) {
                 return $q->between('date_activated', $start_date, $end_date);
            })
            ->where(['referred_by' => $this->Auth->User('id')]);
            $referralSecond = $query->count();
            $referralSecondIds = [];

            foreach ($query as $referrals) {
                $referralSecondIds = $referrals->id;
            }
        }else{
            $referralSecond = 0;
        }
        //Third level referral
        if(!empty($referralSecondIds)){
           $referralThird = [];
            $query = $this->Users->find('all') 
            ->where(function ($q) use ($start_date, $end_date) {
                 return $q->between('date_activated', $start_date, $end_date);
            })
            ->where(['referred_by' => $referralSecondIds]);
            $referralThird = $query->count();
            $referralThirdIds = [];

            foreach ($query as $referrals) {
                $referralThirdIds = $referrals->id;
            }
        }else{
            $referralThird = 0;
        }
        $user = $this->Users->get($this->Auth->User('id'), [
         'contain' => ['Packages']
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
}
