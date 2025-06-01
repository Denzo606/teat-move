<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
    $category = $conn->query("SELECT * FROM sub_categories where id =" . $_GET['id']);
    foreach ($category->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
$stmt = $conn->query("SELECT id ,cate_name FROM categories");
$Categories = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<div class="container-fluid">
    <div id="msg"></div>

    <form id="manage-sub-category">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <div class="form-group" style="margin-top: 30px;">
            <label for="category_id">
                <span style="color: red;">*</span> ប្រភេទទំនិញ
            </label>
            <select name="category_id" id="category_id" class="custom-select">
                <option value="">-- ជ្រើសរើស --</option>
                <?php
                foreach ($Categories as $Category) {
                    $selected = isset($meta['category_id']) && $meta['category_id'] == $Category['id'] ? 'selected' : '';
                    echo "<option value='" . $Category['id'] . "' " . $selected . ">" . $Category['cate_name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sub_cate">
                <span style="color: red;">*</span> ឈ្មោះប្រភេទទំនិញរង
            </label>
            <input type="text" name="sub_cate" id="sub_cate" class="form-control" value="<?php echo isset($meta['sub_cate']) ? $meta['sub_cate'] : '' ?>" required>
        </div>
    </form>
</div>

<style>
    /* Toast styling for different operations */
    #alert_toast .toast-body {
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        font-family: 'Kantumruy Pro', sans-serif;
    }

    #alert_toast {
        max-width: 400px;
    }

    /* Custom toast colors for different operations */
    #alert_toast.create-success {
        background-color: #28a745 !important;
    }

    #alert_toast.edit-success {
        background-color: #ffc107 !important;
    }

    #alert_toast.delete-success {
        background-color: #dc3545 !important;
    }

    /* Toast text color */
    #alert_toast .toast-body {
        color: white !important;
    }
</style>

<script>
    $('#manage-sub-category').submit(function(e) {
        e.preventDefault();
        start_load();
        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?action=save_sub_category',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                console.log('Response:', resp);
                if (resp == 1) {
                    if ($('input[name="id"]').val() === '') {
                        // This is a new sub-category
                        create_success();
                    } else {
                        // This is an edit
                        edit_success();
                    }
                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger" style="font-size: 18px; font-family: \'Kantumruy Pro\', sans-serif;">ប្រភេទទំនិញរងមានរួចហើយ</div>');
                } else {
                    console.error('Error response:', resp);
                    $('#msg').html('<div class="alert alert-danger" style="font-size: 18px; font-family: \'Kantumruy Pro\', sans-serif;">មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ</div>');
                }
                end_load();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#msg').html('<div class="alert alert-danger" style="font-size: 18px; font-family: \'Kantumruy Pro\', sans-serif;">មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ</div>');
                end_load();
            }
        });
    });
</script>