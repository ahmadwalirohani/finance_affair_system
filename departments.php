<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM departments");
    $stmt->execute();

    // Fetch all results
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> څانګي تنظیم </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">څانګي ثبت</h3>
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

                            <form class="row" id="department-form" action="actions/create_department.php" method="post">
                                <div class="col-5">
                                    <input type="text" id="department-name" name="name" required class="form-control" placeholder="څانګي نوم *">
                                </div>
                                <div class="col-4">
                                    <input type="text" id="department-faculty" name="faculty" required class="form-control" placeholder="څانګي پوهنځي *">
                                </div>
                                <div class="col-3">
                                    <button type="submit" id="department-submit" class="btn btn-primary btn-block">ثبت</button>
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
                                        <th>پوهنځي</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($departments as $department) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($department['id']); ?></td>
                                            <td><?php echo htmlspecialchars($department['name']); ?></td>
                                            <td><?php echo htmlspecialchars($department['faculty_name']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_department" data-id="<?php echo implode(',', [$department['id'], $department['name'], $department['faculty_name']]) ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_department.php?id=<?php echo $department['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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

        $(document).on('click', '.edit_department', function() {
            const params = this.dataset.id.split(',');
            $('#department-form').attr('action', 'actions/edit_department.php?id=' + params[0]);
            $('#department-name').val(params[1]);
            $('#department-faculty').val(params[2]);
            $('#department-submit').text('تغیر');
        });


    });
</script>