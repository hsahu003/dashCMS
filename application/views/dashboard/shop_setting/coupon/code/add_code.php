<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
	
</div>

<div class="container dashborad-working-area">	
<?php if(isset($execute)):?>
	<div class="error-display-container error-display-container-add-admin">
		<div class="container m-4 border-radius-2 error-container">
			<?=$message?>
		</div>
	</div>
<?php endif?>
<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
	<div class="font-size-4p5 font-weight-5 mb-2 f-color-3">
		Add Coupon Code
	</div>
	<?=form_open('dashboard/shop-setting/coupon/add/code','')?>
	<div class="row dashboard-widget-container align-items-y">
		<div class="col ds-col-6 dashboard-widget">
			<div class="container">
				<div class="row align-items-x-start flex border-b">
					<div class="col">
						<div class="border-radius-top-2 p-3 width-100">
							Coupon name and description
						</div>
					</div>
					<div class="col">
						<div class="tooltip">
							<span><?= display_icon('tool_tip_circle','','17px','')?></span>
								<span class="tooltiptext">Tooltip text</span>
						</div>
					</div>
				</div>
			</div>
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!--Coupon name-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Coupon code name</label>
									<input class="mb-2 p-3" type="text" name="coupon_name" value="<?= set_value('coupon_name')?>">
								</div>
							</div>
							<!--Coupon description-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Product Description</label>
									<textarea name="description" rows='4' cols="50" name="product_decsription"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--widget for discount details-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Discount details
							</div>
						</div>
						<div class="col">
							<div class="tooltip">
								<span><?= display_icon('tool_tip_circle','','17px','')?></span>
									<span class="tooltiptext">Tooltip text</span>
							</div>
						</div>
					</div>
				</div>
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!-- discount type -->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Discount Type</label>
									<select class="p-3" name="discount_type">
										<option value="percent">Percent</option>
										<option value="float">Amount</option>
									</select>
								</div>
							</div>
							<!-- dicount value -->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="container">
										<div class="row flex">
											<div class="col">
												<div class="border-radius-top-2 px-2 width-100">
													<label>Discount amount/percent</label>
												</div>
											</div>
											<div class="col">
												<div class="tooltip">
													<span><?= display_icon('tool_tip_circle','','17px','')?></span>
														<span class="tooltiptext">Add only numeric value even if the discount type is percent base</span>
												</div>
											</div>
										</div>
									</div>
									<input class="mb-2 p-3" type="text" name="discount_value" value="<?= set_value('discount_value')?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--new row-->
		<div class="row flex-col dashboard-widget-container align-items-y">
			<!--widget for usage limit-->
			<div class="col ds-col-6 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Coupon use limits
							</div>
						</div>
						<div class="col">
							<div class="tooltip">
								<span><?= display_icon('tool_tip_circle','','17px','')?></span>
									<span class="tooltiptext">Tooltip text</span>
							</div>
						</div>
					</div>
				</div>
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!-- valid till -->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Valid till</label>
									<input class="width-50 p-3 border-radius-2" type="date" name="valid_till">
								</div>
							</div>
							<!-- Total quantity -->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="container">
										<div class="row flex">
											<div class="col">
												<div class="border-radius-top-2 px-2 width-100">
													<label>Coupon use limits</label>
												</div>
											</div>
											<div class="col">
												<div class="tooltip">
													<span><?= display_icon('tool_tip_circle','','17px','')?></span>
														<span class="tooltiptext">Enter 0 if there is no use limit</span>
												</div>
											</div>
										</div>
									</div>
									
									<input class="mb-2 p-3" type="text" name="coupon_quantity" value="<?= set_value('coupon_quantity')?>">
								</div>
							</div>
							<!-- Limit per person -->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="container">
										<div class="row flex">
											<div class="col">
												<div class="border-radius-top-2 px-2 width-100">
													<label>Limit per person</label>
												</div>
											</div>
											<div class="col">
												<div class="tooltip">
													<span><?= display_icon('tool_tip_circle','','17px','')?></span>
														<span class="tooltiptext">Enter 0 if there is no limit per person</span>
												</div>
											</div>
										</div>
									</div>
									<input class="mb-2 p-3" type="text" name="limit_per_person" value="<?= set_value('limit_per_person')?>">
								</div>
							</div>
						</div>
						<div class="row px-child-1">
							<div class="col">
								<div class="form-element flex-col mt-0">
									<input class="btn-rect-rounded border-soft px-5" type="submit" name="submit" value="Add Coupon">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>
<!--end of the div stared in header.php-->
</div>