<!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
	
</div>
		<div class="container dashborad-working-area">	
			<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
				<textarea id="title" class="border-none border-radius-2 width-100 p-3 mb-3 font-size-4p5 shadow-softer" placeholder="Add Title..."></textarea>
				<script>tinymce.init({ selector:'textarea', selector : "textarea:not(#title)", height : "480"});</script>
				<textarea>Start writing the news here</textarea>

				<span class="mt-3 block"></span>
				<div class="row flex-col dashboard-widget-container">
					<div class="row flex width-100 space-between align-items-y">
						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Featured Image
							</div>
							<div class="dashboard-widget-controls">
								<!--controls for features image-->
								<div class="add-image-button border-soft flex featured-image-button">
									<label class="add-image-btn-label btn-rect-rounded color-none">
									<img class="add-image-icon" src="<?= img_url('add_icon.svg','admins/icons',false,'25px')?>">
									<input type="file" class="image-input" id="file" name="file" onchange="upload_image(0,event)">
								    </label>

								    <div class="image-uploded">
										<img style="width: 100%" src="">
										<div class="remove-image-button flex" onclick="remove_image(0,event)">
											<img class="add-image-icon" src="<?= img_url('add_icon.svg','admins/icons',false,'25px')?>">
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Gallery Images
							</div>
							<div class="dashboard-widget-controls news-gallary-images flex">
								<div class="add-image-button border-soft flex">
									<label class="add-image-btn-label btn-rect-rounded color-none">
										<img class="add-image-icon" src="<?= img_url('add_icon.svg','admins/icons',false,'25px')?>">
										<input type="file" class="image-input" name="file" onchange="upload_image(1,event)">
								    </label>

								    <div class="image-uploded">
										<img style="width: 100%" src="">
										<div class="remove-image-button flex" onclick="remove_image(1,event)">
											<img class="add-image-icon" src="<?= img_url('add_icon.svg','admins/icons',false,'25px')?>">
										</div>
									</div>
								</div>					
							</div>
						</div>
						
					</div>
					<div class="row flex width-100 space-between align-items-y">
						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Action
							</div>
							<div class="dashboard-widget-controls">
								<div class="container">
									<div class="row">
										
									</div>

									<div class="row">
										<div class="col btn-rect-rounded mr-2 border-soft">
											Publish
										</div>

										<div class="col btn-rect-rounded mr-2 border-soft">
											Save Draft
										</div>

										<div class="col btn-rect-rounded border-soft">
											Delete
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Tags
							</div>
							<div class="dashboard-widget-controls">
								<div class="container width-100">
									<div class="row">
										<div class="col flex width-100">
											<input type="text" name="tags" id="news-tags" placeholder="add tags">
											<div id="add-tag" class="ml-2 shadow-softer border-soft btn-rect-rounded unselectable">Add</div>
										</div>
									</div>

									<div id="tags-added-container" class="row mt-3 tags-added-container block">
										<!--elements here will get dynamically genereated -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
</div>