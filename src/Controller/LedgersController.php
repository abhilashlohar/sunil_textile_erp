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
        $ledgers = $this->paginate($this->Ledgers->find()->where(['freeze'=>0]));
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
				//Create Accounting Entry//
				$transaction_date=$this->Auth->User('session_company')->books_beginning_from;
				$AccountingEntry = $this->Ledgers->AccountingEntries->newEntity();
				$AccountingEntry->ledger_id = $ledger->id;
				if($ledger->debit_credit=="Dr")
				{
					$AccountingEntry->debit = $ledger->opening_balance_value;
				}
				if($ledger->debit_credit=="Cr")
				{
					$AccountingEntry->credit = $ledger->opening_balance_value;
				}
				$AccountingEntry->transaction_date      = date("Y-m-d",strtotime($transaction_date));
				$AccountingEntry->company_id            = $company_id;
				$AccountingEntry->is_opening_balance    = 'yes';
				$this->Ledgers->AccountingEntries->save($AccountingEntry);
				
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list');
        $suppliers = $this->Ledgers->Suppliers->find('list')->where(['freeze'=>0]);
        $customers = $this->Ledgers->Customers->find('list')->where(['freeze'=>0]);
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
            'contain' => ['AccountingEntries']
        ]);
		
		$company_id=$this->Auth->User('session_company_id');
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            if ($this->Ledgers->save($ledger)) 
			{
				//Accounting Entry
				$query_delete = $this->Ledgers->AccountingEntries->query();
				$query_delete->delete()
				->where(['ledger_id' => $ledger->id,'company_id'=>$company_id])
				->execute();
				
				$transaction_date=$this->Auth->User('session_company')->books_beginning_from;
				$AccountingEntry = $this->Ledgers->AccountingEntries->newEntity();
				$AccountingEntry->ledger_id = $ledger->id;
				if($ledger->debit_credit=="Dr")
				{
					$AccountingEntry->debit = $ledger->opening_balance_value;
				}
				if($ledger->debit_credit=="Cr")
				{
					$AccountingEntry->credit = $ledger->opening_balance_value;
				}
				$AccountingEntry->transaction_date      = date("Y-m-d",strtotime($transaction_date));
				$AccountingEntry->company_id            = $company_id;
				$AccountingEntry->is_opening_balance    = 'yes';
				$this->Ledgers->AccountingEntries->save($AccountingEntry);
				
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $accountingGroups = $this->Ledgers->AccountingGroups->find('list');
        $suppliers = $this->Ledgers->Suppliers->find('list')->where(['freeze'=>0]);
        $customers = $this->Ledgers->Customers->find('list')->where(['freeze'=>0]);
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
        $company_id=$this->Auth->User('session_company_id');
		if ($this->request->is(['post']))
		{
			$ledger = $this->Ledgers->get($id);
			$ledger->freeze=1;
			if ($this->Ledgers->save($ledger)) {
				
				$this->Flash->success(__('The ledger has been freezed.'));
			} else {
				$this->Flash->error(__('The ledger could not be freeze. Please, try again.'));
			}
		}
		/* $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        if ($this->Ledgers->delete($ledger)) 
		{
            $this->Flash->success(__('The ledger has been deleted.'));
        } 
		else
		{
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
        } */

        return $this->redirect(['action' => 'index']);
    }
	
	public function trialBalance($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$ledger    = $this->Ledgers->newEntity();
		$company_id=$this->Auth->User('session_company_id');
		$where = [];
		
		if ($this->request->is('post')) 
		{
			$ledgersArray        =[];
			$openingBalanceArray =[];
			$transactionArray    =[];
			$from_date = date("Y-m-d",strtotime($this->request->data['from_date']));
			$to_date = date("Y-m-d",strtotime($this->request->data['to_date']));
			if(!empty($from_date))
			{
				$where['AccountingEntries.transaction_date >='] = $from_date;
				
			}
			
			if(!empty($to_date))
			{
				$where['AccountingEntries.transaction_date <=']  = $to_date;
				$where1['AccountingEntries.transaction_date <='] = $to_date;
			}
			$where['AccountingEntries.company_id']  = $company_id;
			$where1['AccountingEntries.company_id'] = $company_id;
			

			$query = $this->Ledgers->AccountingEntries->find();
			$totalInCaseDebit = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['ledger_id']),
					$query->newExpr()->add(['debit']),
					'decimal'
				);
			$totalOutCaseCredit = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['ledger_id']),
					$query->newExpr()->add(['credit']),
					'decimal'
				);
			$query->select([
				'debit_amount' => $query->func()->sum($totalInCaseDebit),
				'credit_amount' => $query->func()->sum($totalOutCaseCredit),'id','ledger_id'
			])
			->where($where)
			->group('ledger_id')
			->autoFields(true)
			->contain(['Ledgers'])->order(['Ledgers.id'=> 'ASC']);
			
			$trialBalances = ($query);
				
			if(!empty($trialBalances))
			{
				foreach($trialBalances as $trialBalance)
				{
					$transactionArray1[$trialBalance->ledger_id] = $trialBalance->debit_amount;
					$transactionArray2[$trialBalance->ledger_id] = $trialBalance->debit_amount;
					//$transactionArray[$trialBalance->ledger->id][$trialBalance->debit_amount] =$trialBalance->credit_amount;
				}
			}
				
			$query1 = $this->Ledgers->AccountingEntries->find();
			$totalInCaseDebit = $query1->newExpr()
				->addCase(
					$query1->newExpr()->add(['ledger_id']),
					$query1->newExpr()->add(['debit']),
					'decimal'
					);
			$totalOutCaseCredit = $query1->newExpr()
				->addCase(
					$query1->newExpr()->add(['ledger_id']),
					$query1->newExpr()->add(['credit']),
					'decimal'
					);
			$query1->select([
				'debit_amount' => $query1->func()->sum($totalInCaseDebit),
				'credit_amount' => $query1->func()->sum($totalOutCaseCredit),'id','ledger_id'
			])
			->where($where1)
			->group('ledger_id')
			->autoFields(true)
			->contain(['Ledgers'])->order(['Ledgers.id'=> 'ASC']);
			
			$openingBalances = ($query1);
			
			$debitAmount = $this->Ledgers->Companies->ItemLedgers->find();
			$debitAmount->select(['total_debit' => $debitAmount->func()->sum('ItemLedgers.amount')])
						->where(['ItemLedgers.is_opening_balance'=> 'yes','company_id' => $company_id]);
			
			$totalDebit  = $debitAmount->first()->total_debit;
			
			$openingBalanceDebit  = 0;
			$openingBalanceCredit = 0;
			if(!empty($openingBalances))
			{
				foreach($openingBalances as $openingBalance)
				{
					$openingBalanceDebit  += $openingBalance->debit_amount;
					$openingBalanceCredit += $openingBalance->credit_amount;
					$ledgersArray[$openingBalance->ledger->id] = $openingBalance->ledger->name;
					$openingBalanceArray[$openingBalance->ledger->id][$openingBalance->debit_amount] =$openingBalance->credit_amount;
				}
				$openingBalanceDebit = round($openingBalanceDebit,2)+round($totalDebit,2);
				if($openingBalanceDebit > $openingBalanceCredit)
				{
					$creditDiffrence = round($openingBalanceDebit,2)-round($openingBalanceCredit,2);
				}
				elseif($openingBalanceDebit < $openingBalanceCredit)
				{
					$debitDiffrence = round($openingBalanceCredit,2) - round($openingBalanceDebit,2);
				}
			}
			//pr($openingBalanceArray);exit;
		}
		
		$this->set(compact('ledger','from_date','to_date','ledgersArray','transactionArray1','transactionArray2','openingBalanceArray','creditDiffrence','debitDiffrence'));
        $this->set('_serialize', ['ledger']);
    }
}
