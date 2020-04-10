<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CaptchaPayouts Controller
 *
 * @property \App\Model\Table\CaptchaPayoutsTable $CaptchaPayouts
 *
 * @method \App\Model\Entity\CaptchaPayout[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaptchaPayoutsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->CaptchaPayouts->find('all', [
            'contain' => [
                'Users'
            ]
        ]);
        $requests = $this->paginate($query, ['limit' => 10]);
        // pr($requests);die();
        $this->set(compact('requests'));
    }

    /**
     * View method
     *
     * @param string|null $id Captcha Payout id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $captchaPayout = $this->CaptchaPayouts->get($id, [
            'contain' => [],
        ]);

        $this->set('captchaPayout', $captchaPayout);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $captchaPayout = $this->CaptchaPayouts->newEntity();
        if ($this->request->is('post')) {
            $captchaPayout = $this->CaptchaPayouts->patchEntity($captchaPayout, $this->request->getData());
            if ($this->CaptchaPayouts->save($captchaPayout)) {
                $this->Flash->success(__('The captcha payout has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The captcha payout could not be saved. Please, try again.'));
        }
        $this->set(compact('captchaPayout'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Captcha Payout id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $captchaPayout = $this->CaptchaPayouts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $captchaPayout = $this->CaptchaPayouts->patchEntity($captchaPayout, $this->request->getData());
            if ($this->CaptchaPayouts->save($captchaPayout)) {
                $this->Flash->success(__('The captcha payout has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The captcha payout could not be saved. Please, try again.'));
        }
        $this->set(compact('captchaPayout'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Captcha Payout id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $captchaPayout = $this->CaptchaPayouts->get($id);
        if ($this->CaptchaPayouts->delete($captchaPayout)) {
            $this->Flash->success(__('The captcha payout has been deleted.'));
        } else {
            $this->Flash->error(__('The captcha payout could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function captchaPayout () {
        $this->loadModel('Captchas');
        $eleventh = date('Y-m-11');
        $twentysixth = date('Y-m-d', strtotime('-16 days', strtotime($eleventh)));
        $twelfth = date('Y-m-12');
        $twentyfifth = date('Y-m-d', strtotime('+14 days', strtotime($twelfth)));
        $dateNow = date('Y-m-d');
        $user_id = $this->Auth->User('id');
        $total = 0;
        if (($dateNow >= $twentysixth) && ($dateNow <= $eleventh)) {
            $date_start = $twentysixth;
            $date_end = $eleventh;
            $captcha_records = $this->Captchas->find('all')
                ->where(['user_id' => $this->Auth->User('id')])
                ->where(function ($q) use ($date_start, $date_end) {
                    return $q->between('date', $date_start, $date_end);
                });
            foreach ($captcha_records as $c_record) {
                $total += $c_record->count;
            }
        } else {
            $date_start = $twelfth;
            $date_end = $twentyfifth;
            $captcha_records = $this->Captchas->find('all')
                ->where(['user_id' => $this->Auth->User('id')])
                ->where(function ($q) use ($date_start, $date_end) {
                    return $q->between('date', $date_start, $date_end);
                });
            foreach ($captcha_records as $c_record) {
                $total += $c_record->count;
            }
        }
        $captcha_records = $this->paginate($captcha_records, ['limit' => 10]);
        $this->set(compact('captcha_records', 'total', 'date_start', 'date_end'));
    }

    // public function captchaPayout () {
    //     $this->loadModel('Users');
    //     $this->loadModel('Captchas');
    //     $query = $this->Users->find('all') 
    //         ->where(['status' => 'Active'])
    //         ->where(['referred_by' => $this->Auth->User('id')]);
        
    //     $referralFirst = $query->count();
    //     $referralFirstIds = [];
    //     $referralSecondIds = [];
    //     $referralThirdIds = [];
    //     foreach ($query as $referrals) {
    //         $referralFirstIds[] = $referrals->id;
    //     }
        
    //    // Second level referral
    //     if(count($referralFirstIds) > 0){
    //         $referralSecond = [];
    //         $query = $this->Users->find('all') 
    //             ->where(['status' => 'Active'])
    //             ->where(['referred_by IN' => $referralFirstIds]);
    //         $referralSecond = $query->count();
            

    //         foreach ($query as $referrals) {
    //             $referralSecondIds[] = $referrals->id;
    //         }
    //     }else{
    //         $referralSecond = 0;
    //     }
    //     //Third level referral
    //     if(count($referralThirdIds) > 0){
    //        $referralThird = [];
    //         $query = $this->Users->find('all') 
    //             ->where(['status' => 'Active'])
    //             ->where(['referred_by IN' => $referralSecondIds]);
    //         $referralThird = $query->count();
            

    //         foreach ($query as $referrals) {
    //             $referralThirdIds[] = $referrals->id;
    //         }
    //     }else{
    //         $referralThird = 0;
    //     }
    //     $eleventh = date('Y-m-11');
    //     $twentysixth = date('Y-m-d', strtotime('-16 days', strtotime($eleventh)));
    //     $twelfth = date('Y-m-12');
    //     $twentyfifth = date('Y-m-d', strtotime('+14 days', strtotime($twelfth)));
    //     $dateNow = date('Y-m-d');
    //     if (($dateNow >= $twentysixth) && ($dateNow <= $eleventh)) {
    //         $date_start = $twentysixth;
    //         $date_end = $eleventh;
    //         $self_count = 0;
    //         $query = $this->Captchas->find('all')
    //             ->where(['user_id' => $this->Auth->User('id')])
    //             ->where(function ($q) use ($date_start, $date_end) {
    //                 return $q->between('date', $date_start, $date_end);
    //             });
    //         foreach ($query as $c_date) {
    //             $self_count += $c_date->count;
    //         }
    //         $first_level_count = 0;
    //         if (count($referralFirstIds) > 0) {
    //             $query = $this->Captchas->find('all')
    //                 ->where(['user_id IN' => $referralFirstIds])
    //                 ->where(function ($q) use ($date_start, $date_end) {
    //                     return $q->between('date', $date_start, $date_end);
    //                 });
    //             foreach ($query as $c_date) {
    //                 $first_level_count += $c_date->count;
    //             }
    //         }
    //         $second_level_count = 0;
    //         if (count($referralSecondIds) > 0) {
    //             $query = $this->Captchas->find('all')
    //             ->where(['user_id IN' => $$referralSecondIds])
    //                 ->where(function ($q) use ($date_start, $date_end) {
    //                     return $q->between('date', $date_start, $date_end);
    //                 });
    //             foreach ($query as $c_date) {
    //                 $second_level_count += $c_date->count;
    //             }
    //         }
    //         $third_level_count = 0;
    //         if (count($referralThirdIds) > 0) {
    //             $query = $this->Captchas->find('all')
    //                 ->where(['user_id IN' => $referralThirdIds])
    //                 ->where(function ($q) use ($date_start, $date_end) {
    //                     return $q->between('date', $date_start, $date_end   );
    //                 });
    //             foreach ($query as $c_date) {
    //                 $third_level_count += $c_date->count;
    //             }
    //         }
    //         $self = $self_count;
    //         $first = $first_level_count;
    //         $second = $second_level_count * .5;
    //         $third = $third_level_count * .25;
    //         $total = $self + $first + $second + $third;
    //     } else {
    //         $date_start = $twelfth;
    //         $date_end = $twentyfifth;
    //         $self_count = 0;
    //         $query = $this->Captchas->find('all')
    //             ->where(['user_id' => $this->Auth->User('id')])
    //             ->where(function ($q) use ($date_start, $date_end) {
    //                 return $q->between('date', $start_date, $end_date);
    //             });
    //         foreach ($query as $c_date) {
    //             $self_count += $c_date->count;
    //         }
    //         $first_level_count = 0;
    //         $query = $this->Captchas->find('all')
    //             ->where(['user_id IN' => $referralFirstIds])
    //             ->where(function ($q) use ($date_start, $date_end) {
    //                 return $q->between('date', $start_date, $end_date);
    //             });
    //         foreach ($query as $c_date) {
    //             $first_level_count += $c_date->count;
    //         }
    //         $second_level_count = 0;
    //         $query = $this->Captchas->find('all')
    //             ->where(['user_id IN' => $$referralSecondIds])
    //             ->where(function ($q) use ($date_start, $date_end) {
    //                 return $q->between('date', $start_date, $end_date);
    //             });
    //         foreach ($query as $c_date) {
    //             $second_level_count += $c_date->count;
    //         }
    //         $third_level_count = 0;
    //         $query = $this->Captchas->find('all')
    //             ->where(['user_id IN' => $referralThirdIds])
    //             ->where(function ($q) use ($date_start, $date_end) {
    //                 return $q->between('date', $start_date, $end_date);
    //             });
    //         foreach ($query as $c_date) {
    //             $third_level_count += $c_date->count;
    //         }
    //         $self = $self_count;
    //         $first = $first_level_count;
    //         $second = $second_level_count * .5;
    //         $third = $third_level_count * .25;
    //         $total = $self + $first + $second + $third;
    //     }
    //     $this->set(compact('self_count', 'first_level_count', 'second', 'third', 'total', 'date_start', 'date_end'));
    // }

    public function saveRequest () {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $query = $this->CaptchaPayouts->find('all', [
                'conditions' => [
                    'date_start' => $this->request->data['date_start'],
                    'date_end' => $this->request->data['date_end'],
                    'user_id' => $this->Auth->User('id')
                ]
            ]);

            if ($query->count() > 0) {
                $this->Flash->error(__('You already requested for this payout.'));
                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }

            $this->request->data['user_id'] = $this->Auth->User('id');
            $captcha_record = $this->CaptchaPayouts->newEntity($this->request->data);
            if ($this->CaptchaPayouts->save($captcha_record)) {
                $this->Flash->success(__('Payout request has been saved.'));
            }
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }
    }

    public function changeStatus () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $return = [
                'success' => false
            ];
            $request = $this->CaptchaPayouts->get($this->request->data['request_id']);
            $request->status = $this->request->data['status'];
            if ($this->CaptchaPayouts->save($request)) {
                $return['success'] = true;
            }

            echo json_encode($return);
        }
    }

     public function getReports () {
        if ($this->request->is(['ajax', 'get'])) {
            $user_id = $this->Auth->User('id');
            $query = $this->CaptchaPayouts->find('all', [
                'conditions' => [
                    'user_id' => $user_id
                ],
                'order' => [
                    'CaptchaPayouts.id' => 'DESC'
                ]
            ]);

            $requests = $this->paginate($query, ['limit' => 10]);

            $this->set(compact('requests'));
        }
    }
}
