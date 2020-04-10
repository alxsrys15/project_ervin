<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Captchas Controller
 *
 * @property \App\Model\Table\CaptchasTable $Captchas
 *
 * @method \App\Model\Entity\Captcha[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaptchasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        
    }

    /**
     * View method
     *
     * @param string|null $id Captcha id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $captcha = $this->Captchas->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('captcha', $captcha);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $captcha = $this->Captchas->newEntity();
        if ($this->request->is('post')) {
            $captcha = $this->Captchas->patchEntity($captcha, $this->request->getData());
            if ($this->Captchas->save($captcha)) {
                $this->Flash->success(__('The captcha has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The captcha could not be saved. Please, try again.'));
        }
        $users = $this->Captchas->Users->find('list', ['limit' => 200]);
        $this->set(compact('captcha', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Captcha id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $captcha = $this->Captchas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $captcha = $this->Captchas->patchEntity($captcha, $this->request->getData());
            if ($this->Captchas->save($captcha)) {
                $this->Flash->success(__('The captcha has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The captcha could not be saved. Please, try again.'));
        }
        $users = $this->Captchas->Users->find('list', ['limit' => 200]);
        $this->set(compact('captcha', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Captcha id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $captcha = $this->Captchas->get($id);
        if ($this->Captchas->delete($captcha)) {
            $this->Flash->success(__('The captcha has been deleted.'));
        } else {
            $this->Flash->error(__('The captcha could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function solveCaptcha () {
        $this->loadModel('Users');
        if ($this->request->is('post')) {

            $user_id = $this->Auth->User('id');
            $uplines = $this->Users->getUplines($user_id);
            
            $isHuman = captcha_validate($this->request->data['CaptchaCode']);
            unset($this->request->data['CaptchaCode']);
            $dateNow = date('Y-m-d');

            if ($isHuman) {
                $query = $this->Captchas->find('all', [
                    'conditions' => [
                        'date' => $dateNow,
                        'user_id' => $user_id
                    ]
                ]);

                if ($query->first()) {
                    $captcha_record = $query->first();
                    if ($captcha_record->user_count < 120) {
                        $captcha_record->user_count += 1;
                        if ($captcha->count < 500) {
                            $captcha_record->count += 1;
                        }
                        if ($this->Captchas->save($captcha_record)) {
                            $this->addCaptchaCount($uplines['first']);
                            $this->addCaptchaCount($uplines['second']);
                            $this->addCaptchaCount($uplines['third']);
                            $this->Flash->success(__('Congratulations! Captcha solved!'));
                        }
                    } else {
                        $this->Flash->error(__('You have reached the maximum number of captchas per day'));
                    }
                } else {
                    $data = [
                        'date' => $dateNow,
                        'user_id' => $user_id,
                        'count' => 1,
                        'user_count' => 1
                    ];

                    $captcha_record = $this->Captchas->newEntity($data);
                    if ($this->Captchas->save($captcha_record)) {
                        $this->Flash->success(__('Congratulations! Captcha solved!'));
                    }
                }
                return $this->redirect(['controller' => 'Home', 'action' => 'index', "view"]);
            }
            $this->Flash->error(__('Sorry your input is wrong.'));
            return $this->redirect(['controller' => 'Home', 'action' => 'index', "view"]);
        }
    }

    private function addCaptchaCount ($user_id) {
        $dateNow = date('Y-m-d');
        $existing_records = [];
        $existing_ids = [];
        $non_existing_records = [];
        if (!empty($user_id)) {
            $query = $this->Captchas->find('all', [
                'conditions' => [
                    'user_id' => $user_id,
                    'date' => $dateNow
                ]
            ]);

            if ($query->first()) {
                $captcha_record = $query->first();
                if ($captcha_record->count < 500) {
                    $captcha_record->count += 1;
                    $this->Captchas->save($captcha_record);
                }
            } else {
                $data = [
                    'user_id' => $user_id,
                    'date' => $dateNow,
                    'count' => 1
                ];

                $captcha_record = $this->Captchas->newEntity($data);
                $this->Captchas->save($captcha_record);
            }
        }
    }
}
