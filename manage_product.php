<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
    $product = $conn->query("SELECT * FROM products where id =" . $_GET['id']);
    foreach ($product->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}

// Fetch sub-category options with their parent categories from the database
$stmt = $conn->query("SELECT s.id, s.sub_cate, c.cate_name FROM sub_categories s JOIN categories c ON s.category_id = c.id ORDER BY c.cate_name, s.sub_cate");
$SubCategories = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<div class="container-fluid">
    <div id="msg"></div>

    <form id="manage-product" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <div class="form-group" style="margin-top: 30px;">
            <label for="sub_id" class="khmer-text">
                <span style="color: red;">*</span> ប្រភេទទំនិញ
            </label>
            <select name="sub_id" id="sub_id" class="custom-select khmer-text">
                <option value="">ជ្រើសរើសប្រភេទទំនិញ</option>
                <?php
                // Group sub-categories by their parent category
                $currentCategory = '';
                foreach ($SubCategories as $subCat) {
                    // If we're starting a new category, add an optgroup
                    if ($currentCategory != $subCat['cate_name']) {
                        // Close the previous optgroup if not the first one
                        if ($currentCategory != '') {
                            echo "</optgroup>";
                        }
                        $currentCategory = $subCat['cate_name'];
                        echo "<optgroup label='" . $currentCategory . "'>";
                    }
                    
                    $selected = isset($meta['sub_id']) && $meta['sub_id'] == $subCat['id'] ? 'selected' : '';
                    echo "<option value='" . $subCat['id'] . "' " . $selected . ">" . $subCat['sub_cate'] . "</option>";
                }
                // Close the last optgroup
                if ($currentCategory != '') {
                    echo "</optgroup>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="pro_name" class="khmer-text">
                <span style="color: red;">*</span> ឈ្មោះទំនិញ
            </label>
            <input type="text" name="pro_name" id="pro_name" class="form-control khmer-text" value="<?php echo isset($meta['pro_name']) ? $meta['pro_name'] : '' ?>" required autocomplete="off">
        </div>
        <div class="form-group">
            <label for="price" class="khmer-text">
                <span style="color: red;">*</span> តម្លៃ
            </label>
            <input type="number" name="price" id="price" class="form-control" value="<?php echo isset($meta['price']) ? $meta['price'] : '' ?>" required autocomplete="off">
        </div>
        <!-- Updated HTML Code -->
        <div class="form-group">
            <label for="image" class="khmer-text">
                <span style="color: red;">*</span> រូបភាព
            </label>
            <input id="old_image" hidden accept="image/*" value="<?php echo isset($meta['image']) ? $meta['image'] : '' ?>" required>
            <input type="file" name="image" id="image" onchange="showimg();" class="form-control" accept="image/*" value="<?php echo isset($meta['image']) ? $meta['image'] : '' ?>" required>
            <div class="mt-2">
                <img src="assets/uploads/<?php echo isset($meta['image']) ? $meta['image'] : 'default.png' ?>" id="picture" name="picture" width="100px" height="100px" class="img-thumbnail">
            </div>
        </div>
    </form>
</div>
<style>
    .container-fluid {
        padding: 20px;
    }

    #msg {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        font-size: 18px;
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    .custom-select, 
    .form-control {
        font-size: 16px;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        width: 100%;
        height: 45px;
        display: block;
        margin: 0;
    }

    .custom-select {
        background-color: #fff;
        cursor: pointer;
    }

    .custom-select:focus, 
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }

    /* Style for the image upload section */
    .form-group input[type="file"] {
        padding: 8px;
        height: auto;
    }

    .form-group .img-thumbnail {
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 5px;
        background-color: #fff;
    }

    /* Style for required field indicator */
    .form-group label span {
        margin-right: 5px;
    }

    /* Alert toast styling */
    #alert_toast .toast-body {
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
    }

    #alert_toast {
        max-width: 400px;
    }

    /* Error message styling */
    .alert-danger {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
</style>
<script>
    $('#manage-product').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?action=save_product',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if (resp == 1) {
                    if ($('input[name="id"]').val() === '') {
                        // This is a new product
                        $('#alert_toast').removeClass('delete-success edit-success').addClass('create-success');
                        alert_toast("ទិន្នន័យបានរក្សាទុកជោគជ័យ", 'success');
                    } else {
                        // This is an edit
                        $('#alert_toast').removeClass('delete-success create-success').addClass('edit-success');
                        alert_toast("ទិន្នន័យបានកែប្រែជោគជ័យ", 'success');
                    }
                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger" style="font-size: 18px;">ទំនិញមាននៅក្នុងបញ្ជីទំនិញ</div>');
                }
            }
        });
    });
</script>
<script type="text/javascript">
    function showimg() {
        //Display Image
        var input = document.getElementById("image");
        var fReader = new FileReader();
        fReader.readAsDataURL(input.files[0]);
        fReader.onloadend = function(event) {
            var img = document.getElementById("picture");
            img.src = event.target.result;
        }
    }
</script>