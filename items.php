<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM items");
    $stmt->execute();

    // Fetch all results
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> اجناس تنظیم </h1>
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
                            <h3 class="card-title">اجناس ثبت</h3>
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

                            <form class="row" id="item-form" action="actions/create_item.php" method="post">
                                <div class="col-2">
                                    <input type="text" id="item-name" name="name" required class="form-control" placeholder="اجناس نوم *">
                                </div>
                                <div class="col-2">
                                    <input type="text" id="item-type" name="type" required class="form-control" placeholder="اجناس ډول *">
                                </div>
                                <div class="col-2">
                                    <input type="text" id="item-code" name="code" required class="form-control" placeholder="اجناس کود ">
                                </div>
                                <div class="col-1">
                                    <input type="number" step="0.000001" id="item-quantity" name="quantity" required class="form-control" placeholder=" تعداد ">
                                </div>
                                <div class="col-1">
                                    <input type="number" step="0.000001" id="item-price" name="price" required class="form-control" placeholder=" قیمت ">
                                </div>
                                <div class="col-3">
                                    <input type="text" id="item-remarks" name="remarks" required class="form-control" placeholder="توضیحات  ">
                                </div>
                                <div class="col-1">
                                    <button type="submit" id="item-submit" class="btn btn-primary btn-block">ثبت</button>
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
                                        <th>ډول</th>
                                        <th>کود</th>
                                        <th>موجود تعداد</th>
                                        <th>قیمت</th>
                                        <th>توضیحات</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['type']); ?></td>
                                            <td><?php echo htmlspecialchars($item['code']); ?></td>
                                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                                            <td><?php echo htmlspecialchars($item['remarks']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_item" data-id="<?php echo implode(',', [$item['id'], $item['name'], $item['code'], $item['type'], $item['quantity'], $item['price'], $item['remarks']]) ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_item.php?id=<?php echo $item['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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

        $(document).on('click', '.edit_item', function() {
            const params = this.dataset.id.split(',');
            $('#item-form').attr('action', 'actions/edit_item.php?id=' + params[0]);
            $('#item-name').val(params[1]);
            $('#item-type').val(params[3]);
            $('#item-code').val(params[2]);
            $('#item-quantity').val(params[4]);
            $('#item-price').val(params[5]);
            $('#item-remarks').val(params[6]);
            $('#item-submit').text('تغیر');
        });


    });
</script>