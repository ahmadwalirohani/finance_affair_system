<?php
require '../utils/db.php';


try {
    // Prepare the SQL query
    $dedicated_items = $conn->prepare("SELECT dedicated_items.*, items.name as item, items.type as item_type, departments.name as department  FROM dedicated_items INNER JOIN departments ON dedicated_items.department_id = departments.id  INNER JOIN items ON dedicated_items.item_id = items.id");
    $dedicated_items->execute();

    // Fetch all results
    $dedicated_items = $dedicated_items->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>مالي سیستم</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap4.css">

    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="../dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="../dist/css/custom-style.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">د اجناسو تسلیمي راپور</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>جنس نوم</th>
                            <th>څانګه</th>
                            <th> تعداد</th>
                            <th>غوښتونکی نوم</th>
                            <th>توضیحات</th>
                            <th>حالت</th>
                            <th>تاریخ</th>
                            <th>دوره</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dedicated_items as $item) : ?>
                            <?php
                            $jsonItem = json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['id']); ?></td>
                                <td><?php echo htmlspecialchars($item['item']); ?></td>
                                <td><?php echo htmlspecialchars($item['department']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($item['consumer']); ?></td>
                                <td><?php echo htmlspecialchars($item['remarks']); ?></td>
                                <td>
                                    <?php if ($item['is_returned']) { ?>
                                        <span class="badge badge-danger"> واپس سوی</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger"> تسلیم</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars(substr($item['created_at'], 0, 10)); ?></td>
                                <td><?php echo htmlspecialchars($item['period'] ?? ''); ?></td>

                            <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>

        <footer class="main-footer">

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

</body>

<script>
    window.onload = function() {
        window.print();

    }
</script>

</html>