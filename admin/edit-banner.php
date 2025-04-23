<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    // Lấy ID banner cần sửa
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Truy vấn dữ liệu hiện tại
    $query = mysqli_query($con, "SELECT * FROM tblbanner WHERE id = '$id'");
    $banner = mysqli_fetch_assoc($query);
    
    if(!$banner) {
        header('location:manage-banners.php'); // Redirect nếu không tìm thấy
        exit;
    }

    // Xử lý form submit
    if(isset($_POST['submit'])) {
        $title = $_POST['title'];
        $url = $_POST['url'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $currentImage = $banner['image'];
        
        // Xử lý ảnh upload
        if(!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $extension = strtolower(substr($image, -4));
            $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
            
            if(!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('Định dạng ảnh không hợp lệ');</script>";
            } else {
                $imgnewfile = md5($image) . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], "postimages/" . $imgnewfile);
                
                // Xóa ảnh cũ
                if(file_exists("postimages/".$currentImage)) {
                    unlink("postimages/".$currentImage);
                }
                $currentImage = $imgnewfile;
            }
        }
        
        // Cập nhật database
        $updateQuery = mysqli_query($con, 
            "UPDATE tblbanner SET 
                title = '$title', 
                url = '$url', 
                image = '$currentImage', 
                description = '$description', 
                Is_Active = '$status' 
            WHERE id = '$id'");
        
        if($updateQuery) {
            header("Location: manage-banner.php"); // Chuyển hướng ngay lập tức
            exit(); // Dừng toàn bộ quá trình xử lý
        } else {
            $error = "Lỗi: " . mysqli_error($con);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Newsportal | Update Banner</title>
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <script src="assets/js/modernizr.min.js"></script>
</head>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<body class="fixed-left">
    <div id="wrapper">
        <?php include('includes/topheader.php');?>
        <?php include('includes/leftsidebar.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Sửa Banner</h4>
                                <!-- Breadcrumb ... -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title"><b>Sửa Banner</b></h4>
                                <hr />
                                
                                <!-- Hiển thị thông báo -->
                                <?php if(isset($msg)): ?>
                                <div class="alert alert-success"><?php echo $msg; ?></div>
                                <?php endif; ?>
                                <?php if(isset($error)): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Tiêu đề</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="title" 
                                                value="<?php echo htmlentities($banner['title']); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">URL</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="url" 
                                                value="<?php echo htmlentities($banner['url']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Ảnh hiện tại</label>
                                        <div class="col-md-10">
                                            <img id="preview" src="postimages/<?php echo $banner['image']; ?>" height="100">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Ảnh mới</label>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control" onchange="previewImage(event)" name="image">
                                            <small>Để trống nếu giữ nguyên ảnh</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Mô tả</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" rows="5" 
                                                name="description"><?php echo htmlentities($banner['description']); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Trạng thái</label>
                                        <div class="col-md-10">
                                            <select class="form-control" name="status">
                                                <option value="1" <?php echo ($banner['Is_Active'] == 1) ? 'selected' : ''; ?>>Hoạt động</option>
                                                <option value="0" <?php echo ($banner['Is_Active'] == 0) ? 'selected' : ''; ?>>Không hoạt động</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-10">
                                            <button type="submit" class="btn btn-primary" name="submit">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php');?>
        </div>
    </div>
    <!-- Include JS giống file add -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- ... các file JS khác ... -->
</body>

</html>
<?php } ?>