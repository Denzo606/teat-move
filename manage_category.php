<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
    $category = $conn->query("SELECT * FROM categories where id =" . $_GET['id']);
    foreach ($category->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
?>
<div class="container-fluid">
    <div id="msg"></div>

    <form id="manage-category">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <div class="form-group" style="margin-top: 30px;">
            <label for="cate_name">
                <span style="color: red;">*</span> ឈ្មោះប្រភេទទំនិញ
            </label>
            <input type="text" name="cate_name" id="cate_name" class="form-control" value="<?php echo isset($meta['cate_name']) ? $meta['cate_name'] : '' ?>" required>
        </div>
        <!-- <div class="form-group">
        <label for="descriptions">Descriptions</label>
        <input type="text" name="descriptions" id="descriptions" class="form-control" value="<?php echo isset($meta['descriptions']) ? $meta['descriptions'] : '' ?>" required autocomplete="off">
    </div> -->
    </form>
</div>
<style>
    #alert_toast .toast-body {
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
    }

    #alert_toast {
        max-width: 400px;
    }
</style>
<script>
    $('#manage-category').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?action=save_category',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if (resp == 1) {
                    if ($('input[name="id"]').val() === '') {
                        // This is a new category
                        create_success();
                    } else {
                        // This is an edit
                        edit_success();
                    }
                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger" style="font-size: 18px;">ប្រភេទទំនិញមានរួចហើយ</div>');
                }
            }
        });
    });
</script>