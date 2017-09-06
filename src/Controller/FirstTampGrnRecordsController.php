<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FirstTampGrnRecords Controller
 *
 * @property \App\Model\Table\FirstTampGrnRecordsTable $FirstTampGrnRecords
 *
 * @method \App\Model\Entity\FirstTampGrnRecord[] paginate($object = null, array $settings = [])
 */
class FirstTampGrnRecordsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $firstTampGrnRecords = $this->paginate($this->FirstTampGrnRecords);

        $this->set(compact('firstTampGrnRecords'));
        $this->set('_serialize', ['firstTampGrnRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id First Tamp Grn Record id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $firstTampGrnRecord = $this->FirstTampGrnRecords->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('firstTampGrnRecord', $firstTampGrnRecord);
        $this->set('_serialize', ['firstTampGrnRecord']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $firstTampGrnRecord = $this->FirstTampGrnRecords->newEntity();
        if ($this->request->is('post')) {
            $firstTampGrnRecord = $this->FirstTampGrnRecords->patchEntity($firstTampGrnRecord, $this->request->getData());
            if ($this->FirstTampGrnRecords->save($firstTampGrnRecord)) {
                $this->Flash->success(__('The first tamp grn record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The first tamp grn record could not be saved. Please, try again.'));
        }
        $users = $this->FirstTampGrnRecords->Users->find('list', ['limit' => 200]);
        $this->set(compact('firstTampGrnRecord', 'users'));
        $this->set('_serialize', ['firstTampGrnRecord']);
    }

    /**
     * Edit method
     *
     * @param string|null $id First Tamp Grn Record id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $firstTampGrnRecord = $this->FirstTampGrnRecords->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $firstTampGrnRecord = $this->FirstTampGrnRecords->patchEntity($firstTampGrnRecord, $this->request->getData());
            if ($this->FirstTampGrnRecords->save($firstTampGrnRecord)) {
                $this->Flash->success(__('The first tamp grn record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The first tamp grn record could not be saved. Please, try again.'));
        }
        $users = $this->FirstTampGrnRecords->Users->find('list', ['limit' => 200]);
        $this->set(compact('firstTampGrnRecord', 'users'));
        $this->set('_serialize', ['firstTampGrnRecord']);
    }

    /**
     * Delete method
     *
     * @param string|null $id First Tamp Grn Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $firstTampGrnRecord = $this->FirstTampGrnRecords->get($id);
        if ($this->FirstTampGrnRecords->delete($firstTampGrnRecord)) {
            $this->Flash->success(__('The first tamp grn record has been deleted.'));
        } else {
            $this->Flash->error(__('The first tamp grn record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function import()
	{
		$this->viewBuilder()->layout('index_layout');
		$FirstTampGrnRecords = $this->FirstTampGrnRecords->newEntity();
		$user_id=$this->Auth->User('id');
		$company_id=$this->Auth->User('session_company_id');
		if ($this->request->is('post')) 
		{
			
			$csv = $this->request->data['csv'];
			if(!empty($csv['tmp_name']))
			{
				$ext = substr(strtolower(strrchr($csv['name'], '.')), 1); //get the extension 
				
				$arr_ext = array('csv'); 									   
				if (in_array($ext, $arr_ext)) 
				{
                  move_uploaded_file($csv['tmp_name'], WWW_ROOT . '/step_first/'.$user_id.'.'.$ext);
				  $file = WWW_ROOT . '/step_first/'.$user_id.'.csv';
				  $f = fopen($file, 'r') or die("ERROR OPENING DATA");
					$records=0;
					while (($line = fgetcsv($f, 4096, ';')) !== false) 
					{
						$test[]=$line;
						++$records;
					}
					//pr($test);exit;
					foreach($test as $key => $test1)
					{ 
					    if($key!=0)
						{
							$data = explode(",",$test1[0]);
							$FirstTampGrnRecords = $this->FirstTampGrnRecords->newEntity();
							$FirstTampGrnRecords->item_code                       = $data[0];
							$FirstTampGrnRecords->quantity                        = $data[1]; 
							$FirstTampGrnRecords->purchase_rate                   = $data[2];
							$FirstTampGrnRecords->sales_rate                      = $data[3];
							$FirstTampGrnRecords->user_id                         = $user_id;
							$FirstTampGrnRecords->company_id                      = $company_id;
							$FirstTampGrnRecords->processed                       = 'no';
							$FirstTampGrnRecords->is_addition_item_data_required  = 'no';
							$this->FirstTampGrnRecords->save($FirstTampGrnRecords);
						}
					} 
					$this->redirect(array("controller" => "FirstTampGrnRecords", 
                    "action" => "progress"));
					fclose($f);
					$records;
				}
			}
		} 
		$this->set(compact('FirstTampGrnRecords'));
        $this->set('_serialize', ['FirstTampGrnRecords']);
	}
	
	public function progress()
	{
		$this->viewBuilder()->layout('index_layout');
		$FirstTampGrnRecords = $this->FirstTampGrnRecords->newEntity();
		$this->set(compact('FirstTampGrnRecords'));
        $this->set('_serialize', ['FirstTampGrnRecords']);
	}
	
	
	public function ProcessData()
	{
		$user_id=$this->Auth->User('id');
		$company_id=$this->Auth->User('session_company_id');
		
		$FirstTampGrnRecords = $this->FirstTampGrnRecords->find()
								->where(['user_id'=>$user_id,'company_id'=>$company_id,'processed'=>'no'])
								->limit(10);
								//pr($FirstTampGrnRecords->toArray());
		$count = $FirstTampGrnRecords->count();
		foreach($FirstTampGrnRecords as $FirstTampGrnRecord)
		{
			$CheckItem = $this->FirstTampGrnRecords->Companies->Items->exists(['Items.item_code'=>$FirstTampGrnRecord->item_code,'Items.company_id'=>$company_id]);
			$query = $this->FirstTampGrnRecords->query();
			if(!$CheckItem)
			{
				
				$query->update()
					->set(['is_addition_item_data_required' => 'Yes'])
					->where(['FirstTampGrnRecords.id' =>$FirstTampGrnRecord->id])
					->execute();
			}
			
				$query->update()
					->set(['processed' => 'Yes'])
					->where(['FirstTampGrnRecords.id' =>$FirstTampGrnRecord->id])
					->execute();
					
		}
		
		$FirstTampGrnTotalRecords = $this->FirstTampGrnRecords->find()->where(['user_id'=>$user_id,'company_id'=>$company_id])->count();
		$FirstTampGrnTotalProcessedYesRecords = $this->FirstTampGrnRecords->find()->where(['user_id'=>$user_id,'company_id'=>$company_id,'processed'=>'yes'])->count();
		
		
		$progress_percentage = round((($FirstTampGrnTotalProcessedYesRecords*100)/$FirstTampGrnTotalRecords),2);
		$data['percantage'] = $progress_percentage;
		
		if($count<=0)
		{ 
			$data['status'] = "false";
		}
		else
		{
			$data['status'] = "true";
		}
		echo json_encode($data);
		exit;
	}
	
	function csvDownload()
	{

		$this->layout="";
		$filename="Item_csv";
		header ("Expires: 0");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . "GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/vnd.ms-excel");
		header ("Content-Disposition: attachment; filename=".$filename.".csv");
		header ("Content-Description: Generated Report" ); 

		$this->ath();
		$date=date('d-m-y');
		$company_id = $this->Auth->User('session_company_id');
		$user_id=$this->Auth->User('id');
		//$this->loadmodel('FirstTampGrnRecords');
		$FirstTampGrnRecords = $this->FirstTampGrnRecords->find()
								->where(['user_id'=>$user_id,'company_id'=>$company_id,'is_addition_item_data_required'=>'yes']);

		$excel = "Item Code,Quantity,Purchase Rate,Sales Rate,Addition Item Data Required \n";

		foreach($FirstTampGrnRecords as $FirstTampGrnRecord)
		{

			$excel.="$FirstTampGrnRecord->item_code,$FirstTampGrnRecord->quantity,$FirstTampGrnRecord->purchase_rate,$FirstTampGrnRecord->sales_rate,yes \n";               
		}

		echo $excel;      

	}
}
