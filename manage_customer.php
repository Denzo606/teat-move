<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
    $category = $conn->query("SELECT * FROM `customer` where id =" . $_GET['id']);
    foreach ($category->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
?>
<div class="container-fluid">
    <div id="msg"></div>

    <form id="manage-customer">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <div class="form-group">
            <label for="cus_name" class="khmer-text" style="margin-top: 40px;">
                <span style="color: red;">*</span> ឈ្មោះអតិថិជន
            </label>
            <input type="text" name="cus_name" id="cus_name" class="form-control khmer-text" value="<?php echo isset($meta['cus_name']) ? $meta['cus_name'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="cus_phone" class="khmer-text">
                <span style="color: red;">*</span> លេខទូរស័ព្ទ
            </label>
            <input type="text" name="cus_phone" id="cus_phone" class="form-control khmer-text" value="<?php echo isset($meta['cus_phone']) ? $meta['cus_phone'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="address" class="khmer-text">
                <span style="color: red;">*</span> អាសយដ្ឋាន
            </label>
            <input type="text" name="address" id="address" class="form-control khmer-text" value="<?php echo isset($meta['address']) ? $meta['address'] : '' ?>" required>
        </div>
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
    $('#manage-customer').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?action=save_customer',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if (resp == 1) {
                    if ($('input[name="id"]').val() === '') {
                        // This is a new customer
                        $('#alert_toast').removeClass('delete-success edit-success').addClass('create-success');
                        alert_toast("ទិន្នន័យបានរក្សាទុកដោយជោគជ័យ", 'success');
                    } else {
                        // This is an edit
                        $('#alert_toast').removeClass('delete-success create-success').addClass('edit-success');
                        alert_toast("ទិន្នន័យត្រូវបានកែប្រែដោយជោគជ័យ", 'success');
                    }
                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger" style="font-size: 18px;">អតិថិជនមានរួចហើយ</div>');
                }
            }
        });
    });
</script>