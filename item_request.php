<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $items = $conn->prepare("SELECT * FROM items");
    $request_items = $conn->prepare("SELECT request_items.*, items.name as item, items.type as item_type, departments.name as department  FROM request_items INNER JOIN departments ON request_items.department_id = departments.id  INNER JOIN items ON request_items.item_id = items.id");
    $items->execute();
    $request_items->execute();

    // Fetch all results
    $items = $items->fetchAll(PDO::FETCH_ASSOC);
    $request_items = $request_items->fetchAll(PDO::FETCH_ASSOC);

    $DepartmentsSstmt = $conn->prepare("SELECT * FROM departments");
    $DepartmentsSstmt->execute();
    $departments = $DepartmentsSstmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> اجناسو ارډر </h1>
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
                            <h3 class="card-title">جنس اردر ثبت</h3>
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

                            <form class="row" id="form" action="actions/create_item_request.php" method="post">
                                <div class="col-2">
                                    <select type="text" id="item" name="item" required class="form-control" placeholder="جنس نوم *">
                                        <option>د جنس انتخاب</option>
                                        <?php foreach ($items as $item) : ?>
                                            <option value="<?php echo htmlspecialchars($item['id']); ?>">
                                                <?php echo htmlspecialchars($item['name']); ?> &nbsp;&nbsp;&nbsp;
                                                <span style="color=red"><?php echo htmlspecialchars($item['type']); ?></span>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select required type="text" id="department" name="department" required class="form-control" placeholder="څانګه انتخاب *">
                                        <option>د څانګه انتخاب</option>
                                        <?php foreach ($departments as $department) : ?>
                                            <option value="<?php echo htmlspecialchars($department['id']); ?>"><?php echo htmlspecialchars($department['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" id="consumer" name="consumer" required class="form-control" placeholder=" ارډر کوونکی نوم ">
                                </div>
                                <div class="col-1">
                                    <input type="number" step="0.000001" id="quantity" name="quantity" required class="form-control" placeholder=" تعداد ">
                                </div>
                                <div class="col-3">
                                    <input type="text" id="remarks" name="remarks" required class="form-control" placeholder="توضیحات  ">
                                </div>
                                <div class="col-1">
                                    <button type="submit" id="submit" class="btn btn-primary btn-block">ثبت</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>جنس نوم</th>
                                        <th>څانګه</th>
                                        <th> تعداد</th>
                                        <th>ارډر کوونکی نوم</th>
                                        <th>توضیحات</th>
                                        <th>حالت</th>
                                        <th>تاریخ</th>
                                        <th>عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($request_items as $item) : ?>
                                        <?php
                                        $jsonItem = json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                                            <td><?php echo htmlspecialchars($item['item']); ?></td>
                                            <td><?php echo htmlspecialchars($item['department']); ?></td>
                                            <td><?php echo htmlspecialchars($item['request_quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($item['consumer']); ?></td>
                                            <td><?php echo htmlspecialchars($item['remarks']); ?></td>
                                            <td>
                                                <?php if ($item['is_fullfilled']) { ?>
                                                    <span class="badge badge-success">پوره سوي</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger"> معطل</span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo htmlspecialchars(substr($item['created_at'], 0, 10)); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_item" data-id="<?php echo htmlspecialchars($jsonItem, ENT_QUOTES, 'UTF-8'); ?>"> تغیر </button>
                                                    <?php if (!$item['is_fullfilled']) { ?>
                                                        <a button class="btn btn-sm btn-secondary" href="actions/fullfill_request_item.php?id=<?php echo $item['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">تایید کول</a>
                                                    <?php }  ?>
                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_request_item.php?id=<?php echo $item['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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
<?php include('./partials/footer.php') ?>
<script>
    $(function() {

        $(document).on('click', '.edit_item', function() {
            const params = JSON.parse(this.dataset.id);
            $('#form').attr('action', 'actions/edit_request_item.php?id=' + params.id);
            $('#item').val(params.item_id);
            $('#department').val(params.department_id);
            $('#consumer').val(params.consumer);
            $('#quantity').val(params.request_quantity);
            $('#remarks').val(params.remarks);

            $('#submit').text('تغیر');
        });


    });
</script>