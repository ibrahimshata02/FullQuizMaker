<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <h1>Import Data</h1>

        <form method="post" enctype="multipart/form-data">
        <input type="hidden" id="my-ajax-nonce" value="<?php echo wp_create_nonce('my_ajax_nonce'); ?>" />

            <label for="year">Year:</label>
            <input type="text" name="year" required><br>

            <label for="level">Level:</label>
            <input type="text" name="level" required><br>

            <label for="file">Choose Excel File:</label>
            <input type="file" name="file" accept=".xlsx, .xls" required><br>
            <label for="type"> Select Template File </label>
            <select name="type" id="type">
                <option value="Defult">Defult</option>
                <option value="Unrwa">Unrwa</option>
            <input id = "submit" type="button" name="import_data" value="Import Data">

            <input id = "download" type="button" name="import_data" value="Download Default Excel">

        </form>
    </main>
</div>

<script>
var nonce = jQuery("#my-ajax-nonce").val();
var button = jQuery("#submit");
var download = jQuery("#download");
download.click(function () {
    var formData = new FormData();
    formData.append("action", "FQM_download_default_template");
    jQuery.ajax({
        type: "POST",
        url: my_ajax_object.ajaxurl,
        data: formData,
        processData: false, // Important: prevent jQuery from processing the data
        contentType: false, // Important: prevent jQuery from setting contentType
        success: function (response) {
            console.log(response);
        },
    });
});
button.click(function () {
    var formData = new FormData();
    formData.append("action", "FQM_importStudentDataFromExcel");
    formData.append("nonce", nonce);
    formData.append("file", jQuery('input[type="file"]')[0].files[0]);
    formData.append("year", jQuery('input[name="year"]').val());
    formData.append("level", jQuery('input[name="level"]').val());
    formData.append("type", jQuery('select[name="type"]').val());
    jQuery.ajax({
        type: "POST",
        url: my_ajax_object.ajaxurl,
        data: formData,
        processData: false, // Important: prevent jQuery from processing the data
        contentType: false, // Important: prevent jQuery from setting contentType
        success: function (response) {
            console.log(response);
        },
    });
});

  
</script>
