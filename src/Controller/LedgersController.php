<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ledgers Controller
 *
 * @property \App\Model\Table\LedgersTable $Ledgers
 *
 * @method \App\Model\Entity\Ledger[] paginate($object = null, array $settings = [])
 */
class LedgersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
        $this->paginate = [
            'contain' => ['AccountingGroups', 'Companies']
        ];
        $ledgers = $this->paginate($this->Ledgers);
        //pr($ledgers->toArray());exit;
        $this->set(compact('ledgers'));
        $this->set('_serialize', ['ledgers']);
    }

    /**
     * View method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['AccountingGroups', 'Suppliers', 'Customers', 'AccountingEntries']
        ]);

        $this->set('ledger', $ledger);
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $ledger = $this->Ledgers->newEntity();
		$company_id=$this->Auth->User('session_company_id');
        if ($this->request->is('post')) 
		{
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
			$ledger->company_id = $company_id;
            if ($this->Ledgers->save($ledger)) 
			{
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list');
        $suppliers = $this->Ledgers->Suppliers->find('list');
        $customers = $this->Ledgers->Customers->find('list');
        $this->set(compact('ledger', 'accountingGroups',  'suppliers', 'customers'));
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $ledger = $this->Ledgers->get($id, [
            'contain' => []
        ]);
		$company_id=$this->Auth->User('session_company_id');
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) 
			{
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list', ['limit' => 200]);
        $suppliers = $this->Ledgers->Suppliers->find('list');
        $customers = $this->Ledgers->Customers->find('list');
        $this->set(compact('ledger', 'accountingGroups', 'suppliers', 'customers'));
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        if ($this->Ledgers->delete($ledger)) 
		{
            $this->Flash->success(__('The ledger has been deleted.'));
        } 
		else
		{
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
