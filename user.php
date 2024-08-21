<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();

    // Fetch all results
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection
?>

<div class="content-wrapper" style="min-height: 768.666px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> یوزر تنظیم </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">یوزر ثبت</h3>
                        </div>
                        <div class="card-header">

                            <?php
                            if (isset($_SESSION['message'])) :
                            ?>
                                <div class=" alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                    unset($_SESSION['msg_type']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form class="row" id="user-form" enctype="multipart/form-data" action="actions/create_user.php" method="post">
                                <div class="col-3">
                                    <input type="text" id="user-name" name="name" required class="form-control" placeholder="یوزر نوم *">
                                </div>
                                <div class="col-3">
                                    <input type="email" id="user-email" name="email" required class="form-control" placeholder="یوزر ایمیل *">
                                </div>
                                <div class="col-2">
                                    <input type="password" id="user-password" name="password" required class="form-control" placeholder="یوزر پاسورډ *">
                                </div>
                                <div class="col-2">
                                    <input type="file" id="user-photo" accept="image/*" name="photo" required class="form-control" placeholder="یوزر عکس *">
                                </div>
                                <div class="col-2">
                                    <button type="submit" id="user-submit" class="btn btn-primary btn-block">ثبت</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>نوم</th>
                                        <th>ایمیل</th>
                                        <th>عکس</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($user['photo'] ?? ''); ?>" width="70" height="70" alt="">
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_user" data-id="<?php echo implode(',', [$user['id'], $user['name'], $user['email'], $user['photo']]) ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_user.php?id=<?php echo $user['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->

                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<?php include('./partials/footer.php'); ?>
<script>
    $(function() {

        $(document).on('click', '.edit_user', function() {
            const params = this.dataset.id.split(',');
            $('#user-form').attr('action', 'actions/edit_user.php?id=' + params[0]);
            $('#user-name').val(params[1]);
            $('#user-email').val(params[2]);
            $('#user-submit').text('تغیر');
        });


    });
</script>