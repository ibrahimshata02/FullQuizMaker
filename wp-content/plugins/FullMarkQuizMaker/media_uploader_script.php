<?php
include_once "media_uploader_functions.php";
?>
<script language="javascript">
	var WORDPRESS_VER = "<?php echo get_bloginfo("version") ?>";
	var RCS_ADMIN_URL = '<?php echo admin_url() ?>';

	function rcs_addImage_<?php echo $name; ?>(btn_id) {

		var imageFormIndex = (new String(btn_id)).split('_').reverse()[0];
		jQuery('#imageFormIndex').val(imageFormIndex);
		jQuery('#imageEditorGoal').val('slide_image');
		jQuery('html').addClass('Image');


		var frame;
		if (WORDPRESS_VER >= "3.5") {
			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media();
			frame.on("select", function() {
				var attachment = frame.state().get("selection").first();
				var fileurl = attachment.attributes.url;

				jQuery('#<?php echo $name; ?>').val(fileurl);
				frame.close();
				var img = jQuery('#image_holder_<?php echo $name; ?> img');
				if (img) {
					img.remove();
				}

				rcs_addMediumImage_<?php echo $name; ?>(fileurl);
			});
			frame.open();
		} else {
			tb_show("", "media-upload.php?type=image&amp;TB_iframe=true&amp;tab=library");
			return false;
		}
	}

	//---------------------------------------------------------
	function rcs_addMediumImage_<?php echo $name; ?>(attch_url) {
		jQuery.ajax({
			type: 'POST',
			url: RCS_ADMIN_URL + 'admin-ajax.php',
			data: {
				action: 'RCS_GET_MEDIUM_IMG_I',
				attch_url: encodeURIComponent(attch_url)
			},
			success: function(data) {
				console.log("Success!");
				var res = (new String(data)).split('--++##++--');
				jQuery('#image_holder_<?php echo $name; ?>').append('<img style="height: 350px;" class="rounded-3 w-100"  src="' + attch_url + '" id="slide_image_<?php echo $name; ?>" />');
			},
			error: () => {
				console.log("Error");
			}
		});
	}
	//---------------------------------------------------------
	function rcs_addLargeImage(attch_url) {
		jQuery.ajax({
			type: 'POST',
			url: RCS_ADMIN_URL + 'admin-ajax.php',
			data: {
				action: 'RCS_GET_LARGE_IMG_I',
				attch_url: encodeURIComponent(attch_url)
			},
			success: function(data) {
				var res = (new String(data)).split('--++##++--');
				jQuery('#watermark_holder').append('<img src="' + res[1] + '" id="watermark" />');
				jQuery('#watermark_id').val(res[0]);
				jQuery('#deleteWatermark').css('display', 'block');
			}
		});
	}
</script>


<style>
	input[type="text"],
	input[type="search"],
	input[type="radio"],
	input[type="tel"],
	input[type="time"],
	input[type="url"],
	input[type="week"],
	input[type="password"],
	input[type="checkbox"],
	input[type="color"],
	input[type="date"],
	input[type="datetime"],
	input[type="datetime-local"],
	input[type="email"],
	input[type="month"],
	input[type="number"],
	select,
	textarea {
		box-shadow: none !important;
		font-size: 13px;
	}
</style>

<div style="" class="col image_container<?php echo $name; ?>">
	<div class="align-items-center row">
		<div class="col-8">
			<div class="input-group form-row">

				<div class="input-group-prepend">
					<button type="button" class="p-2 border bg-white rounded-2" id="add_image_<?php echo $name; ?>" onclick="rcs_addImage_<?php echo $name; ?>(this.id)"><?php echo "<i title=\"Add new image\" class=\"cursor-pointer fas fa-image text-dark fa-xl\" 
			name=\"$name\" id=\"$name\"   size=\"25\"></i>" ?></button>
				</div>
			</div>
		</div>
	</div>
</div>