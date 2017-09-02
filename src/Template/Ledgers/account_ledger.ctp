<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Account Ledger report');
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold ">Account Ledger</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<form method="GET" >
						<div class="col-md-3">
							<div class="form-group">
								<label>Ledgers</label>
								<?php 
								echo $this->Form->input('ledger_id', ['options'=>$ledgers,'label' => false,'class' => 'form-control input-sm select2me']); 
								?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>From Date</label>
								<?php 
								if(@$from_date=='1970-01-01')
								{
									$from_date = '';
								}
								elseif(!empty($from_date))
								{
									$from_date = date("d-m-Y",strtotime(@$from_date));
								}
								else{
									$from_date = @$coreVariable[fyValidFrom];
								}
								echo $this->Form->control('from_date',['class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','value'=>@$from_date,'data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo]]); ?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>To Date</label>
								<?php 
								if(@$to_date=='1970-01-01')
								{
									$to_date = '';
								}
								elseif(!empty($to_date))
								{
									$to_date = date("d-m-Y",strtotime(@$to_date));
								}
								else{
									$to_date = @$coreVariable[fyValidTo];
								}
								echo $this->Form->control('to_date',['class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','type'=>'text','value'=>@$to_date,'data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo]]); ?>
							</div>
						</div>
						<div class="col-md-2" >
								<div class="form-group" style="padding-top:22px;"> 
									<button type="submit" class="btn btn-xs blue input-sm srch"> Go</button>
								</div>
						</div>	
					</form>
				</div>
				<?php
					if(!empty($AccountingLedgers))
					{
				?>
					<table class="table table-bordered table-hover table-condensed" width="100%">
						<thead>
							<tr>
								<th colspan="3" style="text-align:right";><b>Opening Balance</b></th>
								<th style="text-align:right";>
								<?php
									if(!empty($openingBalance_debit1))
									{
										echo $openingBalance_debit1;
									}
								?>
								</th>
								<th style="text-align:right";>
								<?php
									if(!empty($openingBalance_credit1))
									{
										echo $openingBalance_credit1;
									}
								?>
								</th>
							</tr>
							<tr>
								<th scope="col">Date</th>
								<th scope="col" style="text-align:center";>Voucher Type</th>
								<th scope="col" style="text-align:center";>Voucher No</th>
								<th scope="col" style="text-align:center";>Debit</th>
								<th scope="col" style="text-align:center";>Credit</th>
							</tr>
						</thead>
						<tbody>
						<?php
								if(!empty($AccountingLedgers))
								{
									$total_credit=0;
									$total_debit=0;
									foreach($AccountingLedgers as $AccountingLedger)
									{
						?>
							<tr>
								<td><?php echo date("d-m-Y",strtotime($AccountingLedger->transaction_date)); ?></td>
								<td></td>
								<td></td>
								<td style="text-align:right";>
								<?php 
									if(!empty($AccountingLedger->debit))
									{
										echo $AccountingLedger->debit; 
										$total_debit +=round($AccountingLedger->debit,2);
									}
									else
									{
										echo "-";
									}
								?>
								</td>
								<td style="text-align:right";>
								<?php 
									if(!empty($AccountingLedger->credit))
									{
										echo $AccountingLedger->credit; 
										$total_credit +=round($AccountingLedger->credit,2);
									}else
									{
										echo "-";
									}
								?>
								</td>
							</tr>
						<?php   }   } ?>
						</tbody>
						<tfoot>
							<tr>
								<td scope="col" colspan="3" style="text-align:right";><b>Total</b></td>
								<td scope="col" style="text-align:right";><?php echo @$total_debit;?></td>
								<td scope="col" style="text-align:right";><?php echo @$total_credit;?></td>
							</tr>
							<tr>
								<td scope="col" colspan="3" style="text-align:right";><b>Closing Balance</b></td>
								<td scope="col" style="text-align:right";>
								<?php
									if(!empty($closingBalance_debit1))
									{
										echo $closingBalance_debit1;
									}
								?>
								</td>
								<td scope="col" style="text-align:right";>
								<?php
									if(!empty($closingBalance_credit1))
									{
										echo $closingBalance_credit1;
									}
								?>
								</td>
							</tr>
						</tfoot>
					</table>
				<?php } ?>
			</div>
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

<?php
	$js="
	$(document).ready(function() {
         ComponentsPickers.init();
	})";

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 
?>