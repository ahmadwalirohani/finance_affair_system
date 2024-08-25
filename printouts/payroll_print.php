<?php
require '../utils/db.php';


try {
    // Prepare the SQL query
    $payrolls = $conn->prepare("SELECT payrolls.* , teachers.name as teacher,teachers.job as job FROM payrolls INNER JOIN teachers ON payrolls.teacher_id = teachers.id");

    if (isset($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';

        $payrolls = $conn->prepare(
            "SELECT 
                payrolls.*, 
                teachers.name AS teacher,
                teachers.job AS job
            FROM 
                payrolls 
            INNER JOIN 
                teachers ON payrolls.teacher_id = teachers.id 
            WHERE 
                teachers.name LIKE :t_search 
                OR payrolls.year LIKE :y_search 
                OR payrolls.month LIKE :m_search 
                OR teachers.job LIKE :j_search 
                "
        );

        $payrolls->bindParam(':t_search', $search);
        $payrolls->bindParam(':y_search', $search);
        $payrolls->bindParam(':m_search', $search);
        $payrolls->bindParam(':j_search', $search);
    }

    $payrolls->execute();
    $payrolls = $payrolls->fetchAll(PDO::FETCH_ASSOC);
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
                <h3 class="card-title">د معاشاتو راپور</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ښوونکي</th>
                            <th>وظیفه</th>
                            <th>اصلي معاش</th>
                            <th>ټول کاري ساعت</th>
                            <th>حاضر ورځي</th>
                            <th>غیر حاضر ورځي</th>
                            <th>اضافه کاري</th>
                            <th>خالص معاش</th>
                            <th>دوره</th>
                            <th>تفصیل</th>
                            <th>تاریخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payrolls as $payroll) : ?>

                            <?php
                            $jsonpayroll = json_encode($payroll, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payroll['id']); ?></td>
                                <td><?php echo htmlspecialchars($payroll['teacher']); ?></td>
                                <td><?php echo htmlspecialchars($payroll['job']) ?></td>
                                <td><?php echo htmlspecialchars($payroll['salary']); ?></td>
                                <td><?php echo htmlspecialchars($payroll['total_hours']); ?></td>
                                <td><?php echo htmlspecialchars($payroll['present_days']); ?></td>
                                <td> <b> <?php echo htmlspecialchars($payroll['absent_days']) ?? ''; ?> </b></td>
                                <td> <b> <?php echo htmlspecialchars($payroll['overtime_salary']) ?? ''; ?> </b></td>
                                <td><?php echo htmlspecialchars($payroll['net_salary']) ?? ''; ?></td>
                                <td><?php echo htmlspecialchars($payroll['year']); ?> <?php echo htmlspecialchars($payroll['month']); ?></td>
                                <td><?php echo htmlspecialchars($payroll['remarks']) ?? ''; ?></td>
                                <td><?php echo htmlspecialchars($payroll['created_at']) ?? ''; ?></td>

                            </tr>
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