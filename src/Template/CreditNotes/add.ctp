<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Create Credit Note');
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold ">Credit Note</span>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($creditNote,['onsubmit'=>'return checkValidation()']) ?>
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
						<input type="hidden" name="company_id" class="customer_id" value="<?php echo $company_id;?>">
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
								<?php echo $this->Form->control('sales_ledger_id',['empty'=>'-Select Account-', 'class'=>'form-control input-sm sales_ledger_id select2me','label'=>false, 'options' => $Accountledgers,'required'=>'required']);
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
									<td><label>Taxable Value<label></td>
									<td><label id="gstDisplay">GST<label></td>
									<td><label>Net Amount<label></td>
									<td></td>
								</tr>
							</thead>
							<tbody id='main_tbody' class="tab">
								<tr class="main_tr" class="tab">
									<td>
										<input type="hidden" name="gst_figure_id" class="gst_figure_id" value="">
										<input type="hidden" name="input_cgst_ledger_id" class="input_cgst_ledger_id" value="">
										<input type="hidden" name="input_sgst_ledger_id" class="input_sgst_ledger_id" value="">
										<input type="hidden" name="input_igst_ledger_id" class="input_igst_ledger_id" value="">
										<input type="hidden" name="gst_figure_tax_percentage" class="gst_figure_tax_percentage calculation" value="">
										<input type="hidden" name="tot" class="totamount calculation" value="">
										<input type="hidden" name="gst_value" class="gstValue calculation" value="">
										<input type="hidden" name="discountvalue" class="discountvalue calculation" value="">

									
										<?php echo $this->Form->input('item_id', ['empty'=>'-Item Name-', 'options'=>$itemOptions,'label' => false,'class' =>'form-control input-sm attrGet','required'=>'required']); ?>
										<span class="itemQty" style="color:red"></span>
									</td>
									<td>
										<?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm calculation quantity rightAligntextClass','id'=>'check','required'=>'required','placeholder'=>'Quantity']); ?>
									</td>
									<td>
										<?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm calculation rate rightAligntextClass','required'=>'required','placeholder'=>'Rate']); ?>
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
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="8">	
										<button type="button" class="add_row btn btn-default input-sm"><i class="fa fa-plus"></i> Add row</button>
									</td>
								</tr>
								<tr>
									<td colspan="6" align="right"><b>Amt Before Tax</b></td>
									<td colspan="2">
										<?php echo $this->Form->input('amount_before_tax', ['label' => false,'class' => 'form-control input-sm amount_before_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
									</td>
								</tr>
								<tr id="add_cgst">
									<td colspan="6" align="right"><b>Total CGST</b></td>
									<td colspan="2">
										<?php echo $this->Form->input('total_cgst', ['label' => false,'class' => 'form-control input-sm add_cgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?>	
									</td>
								</tr>
								<tr id="add_sgst">
									<td colspan="6" align="right"><b>Total SGST</b></td>
									<td colspan="2"><?php echo $this->Form->input('total_sgst', ['label' => false,'class' => 'form-control input-sm add_sgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?></td>
								</tr>
								<tr id="add_igst" style="display:none">
									<td colspan="6" align="right"><b>Total IGST</b></td>
									<td colspan="2"><?php echo $this->Form->input('total_igst', ['label' => false,'class' => 'form-control input-sm add_igst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?></td>
								</tr>
								<tr>
									<td colspan="6" align="right"><b>Round OFF</b></td>
									<td colspan="2"><?php echo $this->Form->input('round_off', ['label' => false,'class' => 'form-control input-sm roundValue rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?></td>
								</tr>
								<tr>
									<td colspan="6" align="right"><b>Amt After Tax</b></td>
									<td colspan="2"><?php echo $this->Form->input('amount_after_tax', ['label' => false,'class' => 'form-control input-sm amount_after_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'']); ?></td>
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
			<input type="hidden" name="gst_figure_id" class="gst_figure_id" value="">
			<input type="hidden" name="input_cgst_ledger_id" class="input_cgst_ledger_id" value="">
			<input type="hidden" name="input_sgst_ledger_id" class="input_sgst_ledger_id" value="">
			<input type="hidden" name="input_igst_ledger_id" class="input_igst_ledger_id" value="">
			<input type="hidden" name="gst_figure_tax_percentage" class="gst_figure_tax_percentage calculation" value="">
			<input type="hidden" name="tot" class="totamount calculation" value="">
			<input type="hidden" name="gst_value" class="gstValue calculation" value="">
			<input type="hidden" name="discountvalue" class="discountvalue calculation" value="">

			
				<?php echo $this->Form->input('item_id', ['empty'=>'-Item Name-', 'options'=>$itemOptions,'label' => false,'class' =>'form-control input-sm attrGet','required'=>'required']); ?>
				<span class="itemQty" style="color:red"></span>
			</td>
			<td>
				<?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm calculation quantity rightAligntextClass','id'=>'check','required'=>'required','placeholder'=>'Quantity']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm calculation rate rightAligntextClass','required'=>'required','placeholder'=>'Rate']); ?>
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
				<a class="btn btn-danger delete-tr btn-xs" href="#" role="button" style="margin-bottom: 5px;"><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

<?php
	$js="
	$(document).ready(function() {
		// change item get value start 
		$('.attrGet').die().live('change',function()
		{
			var gst_figure_id=$('option:selected', this).attr('gst_figure_id');
			var gst_figure_tax_percentage=$('option:selected', this).attr('gst_figure_tax_percentage');
			var gst_figure_tax_name=$('option:selected', this).attr('gst_figure_tax_name');
			var output_cgst_ledger_id=$('option:selected', this).attr('output_cgst_ledger_id');
			var output_sgst_ledger_id=$('option:selected', this).attr('output_sgst_ledger_id');
			var output_igst_ledger_id=$('option:selected', this).attr('output_igst_ledger_id');
			var item_qty=$('option:selected', this).attr('item_qty');
			var item_unit=$('option:selected', this).attr('item_unit');
			var itemText=item_qty+' '+item_unit;
			
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.gst_figure_tax_percentage').val(gst_figure_tax_percentage);
			$(this).closest('tr').find('.gst_figure_tax_name').val(gst_figure_tax_name);
			$(this).closest('tr').find('.output_cgst_ledger_id').val(output_cgst_ledger_id);
			$(this).closest('tr').find('.output_sgst_ledger_id').val(output_sgst_ledger_id);
			$(this).closest('tr').find('.output_igst_ledger_id').val(output_igst_ledger_id);
			$('.itemQty').html(itemText);
		});
		// change item get value end 
		
		
		// state wise tax show on customer start
		$('.party_ledger_id').die().live('change',function()
		{
			var customer_state_id=$('option:selected', this).attr('party_state_id');
			var state_id=$('.state_id').val();
			if(customer_state_id!=state_id)
			{
				$('#gstDisplay').html('IGST');
				$('#add_igst').show();
				$('#add_cgst').hide();
				$('#add_sgst').hide();
				$('#is_interstate').val('1');
				}
			else{
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
			$(this).closest('tr').find('.output_igst_ledger_id').val(output_igst_ledger_id);
		});
		// state wise tax show on customer end
		
		
		
		// delete row start
		$('.delete-tr').die().live('click',function() 
		{
			$(this).closest('tr').remove();
			rename_rows();
		});
		//delete row end
		
		
		
		ComponentsPickers.init();
	
		$('.add_row').click(function(){
			add_row();
		}) ;
		
		
		//add row start
		function add_row()
		{
			var tr=$('#sample_table tbody tr.main_tr').clone();
			$('#main_table tbody#main_tbody').append(tr);
			//$('.attrGet').select2();
			rename_rows();
			
		}
		//add row end
		
		//rename rows start
		function rename_rows()
		{
			var i=0;
			$('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
				$(this).find('.attrGet').attr({name:'credit_note_rows['+i+'][item_id]',id:'credit_note_rows['+i+'][item_id]'});
				$(this).find('.quantity').attr({name:'credit_note_rows['+i+'][quantity]',id:'credit_note_rows['+i+'][quantity]'});
				$(this).find('.rate').attr({name:'credit_note_rows['+i+'][rate]',id:'credit_note_rows['+i+'][rate]'});
				$(this).find('.discountAmount').attr({name:'credit_note_rows['+i+'][taxable_value]',id:'credit_note_rows['+i+'][taxable_value]'});
			  
				$(this).find('.gst_figure_id').attr({name:'credit_note_rows['+i+'][gst_figure_id]',id:'credit_note_rows['+i+'][gst_figure_id]'});
			  
				$(this).find('.output_cgst_ledger_id').attr({name:'credit_note_rows['+i+'][output_cgst_ledger_id]',id:'credit_note_rows['+i+'][output_cgst_ledger_id]'});
			  
				$(this).find('.output_sgst_ledger_id').attr({name:'credit_note_rows['+i+'][output_sgst_ledger_id]',id:'credit_note_rows['+i+'][output_sgst_ledger_id]'});
			  
				$(this).find('.output_igst_ledger_id').attr({name:'credit_note_rows['+i+'][output_igst_ledger_id]',id:'credit_note_rows['+i+'][output_igst_ledger_id]'});
				$(this).find('.gstAmount').attr({name:'credit_note_rows['+i+'][net_amount]',id:'credit_note_rows['+i+'][net_amount]'});
				$(this).find('.gstValue').attr({name:'credit_note_rows['+i+'][gst_value]',id:'credit_note_rows['+i+'][gst_value]'});	
					  
				i++;
			});
		}
		//rename row end
		
		
		
		$('.calculation').die().live('keyup',function()
		{
			forward_total_amount();
		});
			
		
		
		//calculation start here
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
			$('#main_table tbody#main_tbody tr.main_tr').each(function()
			{
				var quantity  = parseFloat($(this).find('.quantity').val());
				if(!quantity){quantity=0;}
				var rate  = parseFloat($(this).find('.rate').val());
				if(!rate){rate=0;}
				var totamount = quantity*rate;
				$(this).find('.totamount').val(totamount);
				   
				
				
				var gst_figure_tax_percentage  = parseFloat($(this).find('.gst_figure_tax_percentage').val());
				if(!gst_figure_tax_percentage){gst_figure_tax_percentage=0;}
				
				var gstValue=(totamount*gst_figure_tax_percentage)/100;
				var gstAmount=totamount-gstValue;
				$(this).find('.gstAmount').val(gstAmount.toFixed(2));
				$(this).find('.gstValue').val(gstValue.toFixed(2));

				var taxable_value1=parseFloat($(this).find('.totamount').val());
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
					round_of=parseFloat(total)-parseFloat(roundOff1);
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
				}
				else{
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
			rename_rows();
		}
			
			
		function checkValidation() 
		{  
			var amount_before_tax  = $('.amount_before_tax').val();
			var amount_after_tax = $('.amount_after_tax').val();
			if(amount_before_tax && amount_after_tax)
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
			else{
				   alert('Please enter your data!');
			}
		};
		
	})";
	
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 
?>