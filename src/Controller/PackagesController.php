<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Packages Controller
 *
 * @property \App\Model\Table\PackagesTable $Packages
 *
 * @method \App\Model\Entity\Package[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PackagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $packages = $this->paginate($this->Packages, [
            'limit' => 10
        ]);

        $this->set(compact('packages'));
    }

    /**
     * View method
     *
     * @param string|null $id Package id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $package = $this->Packages->get($id);

            echo json_encode($package);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $package = $this->Packages->newEntity();
        if ($this->request->is('post')) {
            $package = $this->Packages->patchEntity($package, $this->request->getData());
            if ($this->Packages->save($package)) {
                $this->Flash->success(__('The package has been saved.'));

                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
            $this->Flash->error(__('The package could not be saved. Please, try again.'));
        }
        $this->set(compact('package'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Package id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $package = $this->Packages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $package = $this->Packages->patchEntity($package, $this->request->getData());
            if ($this->Packages->save($package)) {
                $this->Flash->success(__('The package has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The package could not be saved. Please, try again.'));
        }
        $this->set(compact('package'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Package id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $package = $this->Packages->get($id);
        if ($this->Packages->delete($package)) {
            $this->Flash->success(__('The package has been deleted.'));
        } else {
            $this->Flash->error(__('The package could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function activatePackage ($package_id, $value = 0) {
        if ($package_id) {
            $package = $this->Packages->get($package_id);
            $package->is_active = $value;
            if ($this->Packages->save($package)) {
                if ($value) {
                    $this->Flash->success(__('Package activated'));
                } else {
                    $this->Flash->success(__('Package deactivated'));
                }
            }
        }
        return $this->redirect(['controller' => 'home', 'action' => 'index']);
    }
}
