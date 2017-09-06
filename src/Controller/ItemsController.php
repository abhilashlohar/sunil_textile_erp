<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\View\Helper\BarcodeHelper;
/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[] paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
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
            'contain' => ['Units', 'StockGroups']
        ];
        $items = $this->paginate($this->Items->find());

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Units', 'StockGroups']
        ]);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $item = $this->Items->newEntity();
		$company_id=$this->Auth->User('session_company_id');
		$this->request->data['company_id'] =$company_id;
		if ($this->request->is('post')) {
			$item = $this->Items->patchEntity($item, $this->request->getData());
			//item code Increment
			$last_item_code=$this->Items->find()->select(['item_code'])->order(['item_code' => 'DESC'])->first();
			if($last_item_code){
				$item->item_code=$last_item_code->item_code+1;
			}else{
				$item->item_code=1;
			} 
			$quantity = $this->request->data['quantity'];

			$gst_type = $this->request->data['kind_of_gst'];
			if($gst_type=='fix')
			{
				$first_gst_figure_id = $this->request->data['first_gst_figure_id'];
				$this->request->data['second_gst_figure_id'] = $first_gst_figure_id;
			}
            if ($this->Items->save($item)) 
			{
				$barcode = new BarcodeHelper(new \Cake\View\View());
				// sample data to encode BLAHBLAH01234
				$data_to_encode = str_pad($item->id, 13, '0', STR_PAD_LEFT);
					
				// Generate Barcode data
				$barcode->barcode();
				$barcode->setType('C128');
				$barcode->setCode($data_to_encode);
				$barcode->setSize(80,200);
					
				// Generate filename            
				$file = 'img/barcode/'.$item->id.'.png';
					
				// Generates image file on server            
				$barcode->writeBarcodeFile($file);
			
			
				$transaction_date=$this->Auth->User('session_company')->books_beginning_from;
				if($quantity>0)
				{
					$itemLedger = $this->Items->ItemLedgers->newEntity();
					$itemLedger->item_id            = $item->id;
					$itemLedger->transaction_date   = date("Y-m-d",strtotime($transaction_date));
					$itemLedger->quantity           = $this->request->data['quantity'];
					$itemLedger->rate               = $this->request->data['rate'];
					$itemLedger->amount             = $this->request->data['amount'];
					$itemLedger->status             = 'in';
					$itemLedger->is_opening_balance = 'yes';
					$itemLedger->company_id         = $company_id;
					$this->Items->ItemLedgers->save($itemLedger);
				}
				
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $units = $this->Items->Units->find('list');
        $stockGroups = $this->Items->StockGroups->find('list');
        $shades = $this->Items->Shades->find('list');
        $sizes = $this->Items->Sizes->find('list');
        $gstFigures = $this->Items->GstFigures->find('list')->where(['GstFigures.company_id'=>$company_id]);
        $this->set(compact('item', 'units', 'stockGroups','sizes','shades','gstFigures'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $item = $this->Items->get($id, [
            'contain' => ['ItemLedgers' => function($q) {
				return $q->where(['ItemLedgers.is_opening_balance'=>'yes']);
			}]
        ]);
		$company_id=$this->Auth->User('session_company_id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
			
			$gst_type = $this->request->data['kind_of_gst'];
			if($gst_type=='fix')
			{
				$first_gst_figure_id = $item->first_gst_figure_id;
				$item->second_gst_figure_id = $first_gst_figure_id;
				$item->gst_amount           = '0';
			}
			//pr($item);exit;
			if ($this->Items->save($item)) {
				if($item->quantity>0)
				{
					$transaction_date=$this->Auth->User('session_company')->books_beginning_from;
					$query_delete = $this->Items->ItemLedgers->query();
						$query_delete->delete()
						->where(['item_id' => $id,'is_opening_balance'=>'yes','company_id'=>$company_id])
						->execute();
						
					$itemLedger = $this->Items->ItemLedgers->newEntity();
					$itemLedger->item_id            = $item->id;
					$itemLedger->transaction_date   = date("Y-m-d",strtotime($transaction_date));
					$itemLedger->quantity           = $this->request->data['quantity'];
					$itemLedger->rate               = $this->request->data['rate'];
					$itemLedger->amount             = $this->request->data['amount'];
					$itemLedger->status             = 'in';
					$itemLedger->is_opening_balance = 'yes';
					$itemLedger->company_id         = $company_id;
					$this->Items->ItemLedgers->save($itemLedger);
				}
				$this->Flash->success(__('The item has been saved.'));
				

                return $this->redirect(['action' => 'index']);
            }
			else
			{ 
				$this->Flash->error(__('The item could not be saved. Please, try again.'));
			}
        }
        $units = $this->Items->Units->find('list');
        $stockGroups = $this->Items->StockGroups->find('list');
		$shades = $this->Items->Shades->find('list');
        $sizes = $this->Items->Sizes->find('list');
		$gstFigures = $this->Items->GstFigures->find('list')->where(['GstFigures.company_id'=>$company_id]);
        $this->set(compact('item', 'units', 'stockGroups','sizes','shades','gstFigures'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function uplodeCsv()
    {
		$this->viewBuilder()->layout('index_layout');
        $uplode_csv = $this->Items->newEntity();
		
		if ($this->request->is('post')) 
		{
			
			$csv = $this->request->data['csv'];
			if(!empty($csv['tmp_name']))
			{
				
				$ext = substr(strtolower(strrchr($csv['name'], '.')), 1); //get the extension 
				
				$arr_ext = array('csv'); 									   
				if (in_array($ext, $arr_ext)) 
				{
								
					$f = fopen($csv['tmp_name'], 'r') or die("ERROR OPENING DATA");
					$batchcount=0;
					$records=0;
					while (($line = fgetcsv($f, 4096, ';')) !== false) 
					{
						$numcols = count($line);
						$test[]=$line;
						++$records;
					}
					foreach($test as $test1)
					{ 
					
						 $data = explode(",",$test1[0]);
						 $item = $this->Items->newEntity();
						 $item->name           = $data[0];
						 $item->item_code      = $data[1]; 
						 $item->hsn_code       = $data[2];
						 $item->unit_id        = $data[3];
						 $item->stock_group_id = $data[4];
						 $item->company_id     = $data[5];
						 $this->Items->save($item);
					} 
					fclose($f);
					$records;

					move_uploaded_file($csv['tmp_name'], WWW_ROOT . '/csv/csv_'.date("d-m-Y").'.'.$ext);
				}
			   
				
			}
		}
        $this->set(compact('uplode_csv'));
        $this->set('_serialize', ['uplode_csv']);
    }
}
