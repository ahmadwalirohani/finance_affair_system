<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM teachers");
    $stmt->execute();

    // Fetch all results
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> ښوونکي تنظیم </h1>
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
                            <h3 class="card-title">ښوونکي ثبت</h3>
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

                            <form class="row" id="form" action="actions/create_teacher.php" method="post">
                                <div class="col-2">
                                    <input type="text" id="name" name="name" required class="form-control" placeholder="ښوونکي نوم *">
                                </div>
                                <div class="col-2">
                                    <input type="text" id="father_name" name="father_name" required class="form-control" placeholder="ښوونکي پلار نوم *">
                                </div>
                                <div class="col-2">
                                    <input id="address" name="address" required class="form-control" placeholder=" ادرس ">
                                </div>
                                <div class="col-2">
                                    <input type="text" id="code" name="code" required class="form-control" placeholder="ښوونکي کود ">
                                </div>
                                <div class="col-1">
                                    <input id="position" name="position" required class="form-control" placeholder="مقام / بست">
                                </div>
                                <div class="col-1">
                                    <input id="job" name="job" required class="form-control" placeholder="وظیفه">
                                </div>
                                <div class="col-1">
                                    <input type="number" id="salary" name="salary" required class="form-control" placeholder="معاش  ">
                                </div>
                                <div class="col-1">
                                    <button type="submit" id="submit" class="btn btn-primary btn-block">ثبت</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>نوم</th>
                                        <th>د پلار نوم</th>
                                        <th>کود</th>
                                        <th> ادرس</th>
                                        <th>بست / مقام</th>
                                        <th>معاش</th>
                                        <th>وظیفه</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($teachers as $teacher) : ?>
                                        <?php
                                        $jsonTeacher = json_encode($teacher, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($teacher['id']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['name']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['father_name']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['code']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['address']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['position']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['salary']); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['job']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_teacher" data-id="<?php echo htmlspecialchars($jsonTeacher, ENT_QUOTES, 'UTF-8'); ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_teacher.php?id=<?php echo $teacher['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
    $(function() {

        $("#example1").DataTable({
            "language": {
                "paginate": {
                    "next": "بعدی",
                    "previous": "قبلی"
                },
                'search': 'سرچ کول',
                "lengthMenu": "کتل _MENU_ راپور"

            },
            "info": false,
        });

        $(document).on('click', '.edit_teacher', function() {
            const params = JSON.parse(this.dataset.id);
            $('#form').attr('action', 'actions/edit_teacher.php?id=' + params.id);
            $('#name').val(params.name);
            $('#father_name').val(params.father_name);
            $('#position').val(params.position);
            $('#address').val(params.address);
            $('#code').val(params.code);
            $('#job').val(params.job);
            $('#salary').val(params.salary);

            $('#submit').text('تغیر');
        });


    });
</script>