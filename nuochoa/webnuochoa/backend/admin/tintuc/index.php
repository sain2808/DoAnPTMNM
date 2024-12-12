<?php
require_once "../../../dbconnect.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tin tức</title>
    <!-- Bootstrap 5.2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome 5.15 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php require_once "../../layouts/sidebar.php"; ?>
            </div>
            <div class="col-9">
                <h2>Quản lý tin tức</h2>

                <?php if (isset($_SESSION['success_message'])) : ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success_message']; ?></div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <a href="create.php" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Thêm tin tức
                </a>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Lấy danh sách tin tức từ CSDL
                        $sql = "SELECT news_id, image, title, content FROM news";
                        $result = mysqli_query($conn, $sql);

                        // Kiểm tra nếu có lỗi trong quá trình truy vấn
                        if (!$result) {
                            die("Có lỗi xảy ra: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {
                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td><img src='../../core/uploads/tintuc/" . $row['image'] . "' alt='News Image' width='50'></td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['content'] . "</td>";
                                echo "<td>
                                        <a href='edit.php?id=" . $row['news_id'] . "' class='btn btn-warning btn-sm'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='delete.php?id=" . $row['news_id'] . "' class='btn btn-danger btn-sm'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                    </td>";
                                echo "</tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Không có tin tức nào.</td></tr>";
                        }

                        // Giải phóng bộ nhớ và đóng kết nối CSDL
                        mysqli_free_result($result);
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
