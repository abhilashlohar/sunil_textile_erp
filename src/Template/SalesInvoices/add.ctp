<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Create Sales Invoice');
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold ">Sales Invoice</span>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($salesInvoice,['onsubmit'=>'return checkValidation()']) ?>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Voucher No :</label>&nbsp;&nbsp;
								<?= h('#'.str_pad($voucher_no, 4, '0', STR_PAD_LEFT)) ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Transaction Date <span class="required">*</span></label>
								<?php echo $this->Form->control('transaction_date',['class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>date('d-m-Y')]); ?>
							</div>
						</div>
						<input type="hidden" name="outOfStock" class="outOfStock" value="0">
						<input type="hidden" name="company_id" class="customer_id" value="<?php echo $company_id;?>">
						<input type="hidden" name="location_id" class="location_id" value="<?php echo $location_id;?>">
						<input type="hidden" name="state_id" class="state_id" value="<?php echo $state_id;?>">
						<input type="hidden" name="is_interstate" id="is_interstate" value="0">
						<input type="hidden" name="isRoundofType" id="isRoundofType" class="isRoundofType" value="0">
						<input type="hidden" name="voucher_no" id="" value="<?= h($voucher_no, 4, '0') ?>">
						<div class="col-md-3">
								<label>Party</label>
								<?php echo $this->Form->control('party_ledger_id',['empty'=>'-Select Party-', 'class'=>'form-control input-sm party_ledger_id select2me','label'=>false, 'options' => $partyOptions,'required'=>'required']);
								?>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Sales Account</label>
								<?php echo $this->Form->control('sales_ledger_id',['class'=>'form-control input-sm sales_ledger_id select2me','label'=>false, 'options' => $Accountledgers,'required'=>'required']);
								?>
							</div>
						</div> 
					</div>
					<br>
				   <div class="row">
				  <div class="table-responsive">
								<table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
								<thead>
								<tr align="center">
									<td width="20%"><label>Item<label></td>
									<td><label>Qty<label></td>
									<td><label>Rate<label></td>
									<td><label>Discount(%)<label></td>
									<td><label>Taxable Value<label></td>
									<td><label id="gstDisplay">GST<label></td>
									<td><label>Net Amount<label></td>
									<td></td>
								</tr>
								</thead>
								<tbody id='main_tbody' class="tab">
								
								</tbody>
								<tfoot>
									<tr>
										<td colspan="8">	
											<button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
										</td>
									</tr>
						<tr>
						<td colspan="6" align="right"><b>Amt Before Tax</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('amount_before_tax', ['label' => false,'class' => 'form-control input-sm amount_before_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
						<tr id="add_cgst">
						<td colspan="6" align="right"><b>Total CGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_cgst', ['label' => false,'class' => 'form-control input-sm add_cgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
									
						<tr id="add_sgst">
						<td colspan="6" align="right"><b>Total SGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_sgst', ['label' => false,'class' => 'form-control input-sm add_sgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
						<tr id="add_igst" style="display:none">
						<td colspan="6" align="right"><b>Total IGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_igst', ['label' => false,'class' => 'form-control input-sm add_igst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
						<tr>
						<td colspan="6" align="right"><b>Round OFF</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('round_off', ['label' => false,'class' => 'form-control input-sm roundValue rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
									
						<tr>
						<td colspan="6" align="right"><b>Amt After Tax</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('amount_after_tax', ['label' => false,'class' => 'form-control input-sm amount_after_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
						</td>
						</tr>
					</tfoot>
					</table>
				   </div>
				  </div>
				  
					
			</div>
				<?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
				<?= $this->Form->end() ?>
		</div>
	</div>
</div>


<!-- BEGIN PAGE LEVEL STYLES -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->css('/assets/global/plugins/clockface/css/clockface.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<!-- END COMPONENTS PICKERS -->

	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/select2/select2.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<!-- END COMPONENTS PICKERS -->
	
	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<!-- END COMPONENTS PICKERS -->

	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->script('/assets/global/scripts/metronic.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/pages/scripts/components-dropdowns.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL SCRIPTS -->

<table id="sample_table" style="display:none;" width="100%">
	<tbody>
		<tr class="main_tr" class="tab">
			<td>
			<input type="hidden" name="" class="outStock" value="0">
			<input type="hidden" name="gst_figure_id" class="gst_figure_id" value="">
			<input type="hidden" name="gst_amount" class="gst_amount" value="">
			<input type="hidden" name="gst_figure_tax_percentage" class="gst_figure_tax_percentage calculation" value="">
			<input type="hidden" name="tot" class="totamount calculation" value="">
			<input type="hidden" name="gst_value" class="gstValue calculation" value="">
			<input type="hidden" name="discountvalue" class="discountvalue calculation" value="">
				<?php echo $this->Form->input('item_id', ['empty'=>'-Item Name-', 'options'=>$itemOptions,'label' => false,'class' =>'form-control input-sm attrGet calculation','required'=>'required']); ?>
				<span class="itemQty" style="color:red;font-size:10px;"></span>
			</td>
			<td>
				<?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm calculation quantity rightAligntextClass','id'=>'check','required'=>'required','placeholder'=>'Quantity']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm calculation rate rightAligntextClass','required'=>'required','placeholder'=>'Rate', 'readonly'=>'readonly']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('discount_percentage', ['label' => false,'class' => 'form-control input-sm calculation discount rightAligntextClass','placeholder'=>'Dis.','value'=>0]); ?>	
			</td>
			<td>
				<?php echo $this->Form->input('taxable_value', ['label' => false,'class' => 'form-control input-sm gstAmount reverse_total_amount rightAligntextClass','required'=>'required','placeholder'=>'Amount', 'readonly'=>'readonly']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('gst_figure_tax_name', ['label' => false,'class' => 'form-control input-sm gst_figure_tax_name rightAligntextClass', 'readonly'=>'readonly','required'=>'required','placeholder'=>'GST']); ?>	
			</td>
			<td>
				<?php echo $this->Form->input('net_amount', ['label' => false,'class' => 'form-control input-sm discountAmount calculation rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'Taxable Value']); ?>					
			</td>
			<td align="center">
				<a class="btn btn-danger delete-tr btn-xs dlt" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

<?php
	$js="
	$(document).ready(function() {
		$('.attrGet').die().live('change',function(){
		var itemQ=$(this).closest('tr');
			var gst_amount=$('option:selected', this).attr('gst_amount');
			var sales_rate=$('option:selected', this).attr('sales_rate');
			$(this).closest('tr').find('.gst_amount').val(gst_amount);
			$(this).closest('tr').find('.rate').val(sales_rate);
			
			var itemId=$(this).val();
		var url='".$this->Url->build(["controller" => "SalesInvoices", "action" => "ajaxItemQuantity"])."';
		url=url+'/'+itemId
		$.ajax({
			url: url,
			type: 'GET'
			//dataType: 'text'
		}).done(function(response) {
			var fetch=$.parseJSON(response);
			var text=fetch.text;
			var type=fetch.type;
			itemQ.find('.itemQty').html(text);
			if(type=='true')
			{
				itemQ.find('.outStock').val(1);
			}
			else{
				itemQ.find('.outStock').val(0);
			}
		});	
		forward_total_amount();
		});
		
		$('.party_ledger_id').die().live('change',function(){
			var customer_state_id=$('option:selected', this).attr('party_state_id');
			var state_id=$('.state_id').val();
			if(customer_state_id!=state_id)
			{
			if(customer_state_id>0)
			{
			$('#gstDisplay').html('IGST');
			$('#add_igst').show();
			$('#add_cgst').hide();
			$('#add_sgst').hide();
			$('#is_interstate').val('1');
			}
			else if(!customer_state_id)
			{
			$('#gstDisplay').html('GST');
			$('#add_cgst').show();
			$('#add_sgst').show();
			$('#add_igst').hide();
			$('#is_interstate').val('0');
			}
			else if(customer_state_id==0)
			{
			$('#gstDisplay').html('GST');
			$('#add_cgst').show();
			$('#add_sgst').show();
			$('#add_igst').hide();
			$('#is_interstate').val('0');
			}
			}
			else if(customer_state_id==state_id){
			$('#gstDisplay').html('GST');
			$('#add_cgst').show();
			$('#add_sgst').show();
			$('#add_igst').hide();
			$('#is_interstate').val('0');
			}
			$(this).closest('tr').find('.output_igst_ledger_id').val(output_igst_ledger_id);
		});
		
		$('.cashCredit').die().live('change',function(){
			var cashcredit=$(this).val();
			if(cashcredit=='credit')
			{
				$('#cusomerIds').show();
				$('.customer_id').attr('required', 'required');
			}
			else{
				$('#cusomerIds').hide();
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
			    $('#add_sgst').show();
			    $('#add_igst').hide();
				$('#is_interstate').val('0');
				$('.customer_id').removeAttr('required');
			}
		});
		$('.delete-tr').die().live('click',function() 
		{
			$(this).closest('tr').remove();
			rename_rows();
		});
		ComponentsPickers.init();
	});
	$('.add_row').click(function(){
		add_row();
    }) ;
	$( document ).ready(add_row);
	function add_row()
	{
		var tr=$('#sample_table tbody tr.main_tr').clone();
		$('#main_table tbody#main_tbody').append(tr);
		rename_rows();
		forward_total_amount();
	}
	function rename_rows()
	{
		var i=0;
		$('#main_table tbody#main_tbody tr.main_tr').each(function(){
			$(this).find('td:nth-child(1) select.attrGet').select2().attr({name:'sales_invoice_rows['+i+'][item_id]',id:'sales_invoice_rows['+i+'][item_id]'});
			$(this).find('.quantity').attr({name:'sales_invoice_rows['+i+'][quantity]',id:'sales_invoice_rows['+i+'][quantity]'});
			$(this).find('.rate').attr({name:'sales_invoice_rows['+i+'][rate]',id:'sales_invoice_rows['+i+'][rate]'});
			$(this).find('.discount').attr({name:'sales_invoice_rows['+i+'][discount_percentage]',id:'sales_invoice_rows['+i+'][discount_percentage]'});

			$(this).find('.gstAmount').attr({name:'sales_invoice_rows['+i+'][taxable_value]',id:'sales_invoice_rows['+i+'][taxable_value]'});

			$(this).find('.gst_figure_id').attr({name:'sales_invoice_rows['+i+'][gst_figure_id]',id:'sales_invoice_rows['+i+'][gst_figure_id]'});


			$(this).find('.discountAmount').attr({name:'sales_invoice_rows['+i+'][net_amount]',id:'sales_invoice_rows['+i+'][net_amount]'});
			$(this).find('.gstValue').attr({name:'sales_invoice_rows['+i+'][gst_value]',id:'sales_invoice_rows['+i+'][gst_value]'});	
			if(i==0)
			{
			 $(this).closest('tr').find('.dlt').remove();
			}
			i++;
		});
	}
	$('.calculation').die().live('keyup',function()
	{
		forward_total_amount();
	});
	
		
	function forward_total_amount()
	{
		var total  = 0;
		var gst_amount  = 0;
		var gst_value  = 0;
		var s_cgst_value=0;
		var roundOff1=0;
		var round_of=0;
		var isRoundofType=0;
		var igst_value=0;
		var outOfStockValue=0;
		$('#main_table tbody#main_tbody tr.main_tr').each(function()
		{
		
			var outdata=$(this).closest('tr').find('.outStock').val();
			if(!outdata){outdata=0;}
			outOfStockValue=parseFloat(outOfStockValue)+parseFloat(outdata);
			
			var quantity  = Math.round($(this).find('.quantity').val());
			if(!quantity){quantity=0;}
			var rate  = parseFloat($(this).find('.rate').val());
			if(!rate){rate=0;}
			var totamount = quantity*rate;
			$(this).find('.totamount').val(totamount);
			   
			var discount  = parseFloat($(this).find('.discount').val());
			if(!discount){discount=0;}
			var discountValue=(discount*totamount)/100;
			var discountAmount=totamount-discountValue;
			
			if(!discountAmount){discountAmount=0;}
			$(this).find('.discountAmount').val(discountAmount.toFixed(2));
			var gst_ietmamount  = $(this).find('.gst_amount').val();
			var discountAmount  = $(this).find('.discountAmount').val();
			var item_gst_amount=discountAmount/quantity;
			
			if(item_gst_amount<=gst_ietmamount)
			{
				var first_gst_figure_tax_percentage=$('option:selected', this).attr('FirstGstFigure');
				var first_gst_figure_tax_name=$('option:selected', this).attr('FirstGstFigure');
				var first_gst_figure_id=$('option:selected', this).attr('first_gst_figure_id');
					
				$(this).closest('tr').find('.gst_figure_id').val(first_gst_figure_id);
				$(this).closest('tr').find('.gst_figure_tax_percentage').val(first_gst_figure_tax_percentage);
				$(this).closest('tr').find('.gst_figure_tax_name').val(first_gst_figure_tax_name);
			}
			else if(item_gst_amount>gst_ietmamount)
			{
				var second_gst_figure_tax_percentage=$('option:selected', this).attr('SecondGstFigure');
				var second_gst_figure_tax_name=$('option:selected', this).attr('SecondGstFigure');
				var second_gst_figure_id=$('option:selected', this).attr('second_gst_figure_id');

				$(this).closest('tr').find('.gst_figure_id').val(second_gst_figure_id);
				$(this).closest('tr').find('.gst_figure_tax_percentage').val(second_gst_figure_tax_percentage);
				$(this).closest('tr').find('.gst_figure_tax_name').val(second_gst_figure_tax_name);
			}
			
			$(this).find('.discountvalue').val(discountValue.toFixed(2));
			
			var gst_figure_tax_percentage  = parseFloat($(this).find('.gst_figure_tax_percentage').val());
			if(!gst_figure_tax_percentage){gst_figure_tax_percentage=0;}
			var discountAmount  = parseFloat($(this).find('.discountAmount').val());
			if(!discountAmount){discountAmount=0;}
			var divideValue=100;
			var divideval=divideValue+gst_figure_tax_percentage;
			var gstAmount=(discountAmount*100)/divideval;
			var gstValue=(gstAmount*gst_figure_tax_percentage)/100;
			$(this).find('.gstAmount').val(gstAmount.toFixed(2));
			$(this).find('.gstValue').val(gstValue.toFixed(2));

			var taxable_value1=parseFloat($(this).find('.discountAmount').val());
			total=parseFloat(total)+taxable_value1;
			roundOff1=Math.round(total);
			
			var gstAmount  = parseFloat($(this).find('.gstAmount').val());
			gst_amount=parseFloat(gst_amount)+parseFloat(gstAmount);
			
			if(total<roundOff1)
			{
				round_of=parseFloat(roundOff1)-parseFloat(total);
				isRoundofType='0';
			}
			if(total>roundOff1)
			{
				round_of=parseFloat(roundOff1)-parseFloat(total);
				isRoundofType='1';
			}
			if(total==roundOff1)
			{
			round_of=parseFloat(total)-parseFloat(roundOff1);
			isRoundofType='0';
			}
			
			var gstValue  = parseFloat($(this).find('.gstValue').val());
			var is_interstate  = parseFloat($('#is_interstate').val());
			if(is_interstate=='0')
			{
				gst_value=parseFloat(gst_value)+gstValue;
				s_cgst_value=parseFloat(gst_value/2);
				igst_value=0;
			}else{
				gst_value=parseFloat(gst_value)+gstValue;
				igst_value=parseFloat(gst_value);
				s_cgst_value=0;
			}
		});
		$('.amount_after_tax').val(roundOff1);
		$('.amount_before_tax').val(gst_amount.toFixed(2));
		$('.add_cgst').val(s_cgst_value.toFixed(2));
		$('.add_sgst').val(s_cgst_value.toFixed(2));
		$('.add_igst').val(igst_value.toFixed(2));
		$('.roundValue').val(round_of.toFixed(2));
		$('.isRoundofType').val(isRoundofType);
		$('.outOfStock').val(outOfStockValue);
		rename_rows();
	}
		
	function checkValidation() 
	{  
		var amount_before_tax  = $('.amount_before_tax').val();
		var amount_after_tax = $('.amount_after_tax').val();
		var outOfStock = $('.outOfStock').val();
		if(amount_before_tax && amount_after_tax && outOfStock==0)
		{
			if(confirm('Are you sure you want to submit!'))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else if(outOfStock>0) {
			alert('Please check, you have added out of stock data!');
			return false;
		}
	}";

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 
?>