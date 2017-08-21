<?php
/**
 * @Author: Kounty
 */
$this->set('title', 'Edit Customer | Sunil Textile ERP');
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold ">Edit Customer</span>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($customer) ?>
				<div class="row">
					<div class="col-md-12">
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Customer Name <span class="required">*</span></label>
							<?php echo $this->Form->control('name',['class'=>'form-control input-sm','placeholder'=>'Customer Name','label'=>false,'autofocus']); ?>
						</div>
						<div class="form-group">
							<label>Gst In <span class="required">*</span></label>
							<?php echo $this->Form->control('gstin',['class'=>'form-control input-sm','placeholder'=>'Gst In','label'=>false,'autofocus']); ?>
						</div>
						<div class="form-group">
							<label>Mobile </label>
							<?php echo $this->Form->control('mobile',['class'=>'form-control input-sm','placeholder'=>'Mobile no','label'=>false,'autofocus','maxlength'=>10]); ?>
						</div>
						<div class="form-group">
							<label>Bill to Bill Accounting </label>
							<?php 
							$option =[['value'=>'yes','text'=>'yes'],['value'=>'no','text'=>'no']];
							echo $this->Form->control('bill_to_bill_accounting',['class'=>'form-control input-sm','label'=>false, 'options' => $option,'required'=>'required','value'=>$customer->ledger->bill_to_bill_accounting]); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>State <span class="required">*</span></label>
							<?php echo $this->Form->control('state_id',['class'=>'form-control input-sm','label'=>false,'empty'=>'-State-', 'options' => $states,'required'=>'required']); ?>
						</div>
						<div class="form-group">
							<label>Email</label>
							<?php echo $this->Form->control('email',['class'=>'form-control input-sm','label'=>false,'placeholder'=>'example@domain.com']); ?>
						</div>
						<div class="form-group">
							<label>Address</label>
							<?php echo $this->Form->control('address',['class'=>'form-control input-sm','label'=>false]); ?>
						</div>
							</div>
						</div>
					</div>
				</div>
				<?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>