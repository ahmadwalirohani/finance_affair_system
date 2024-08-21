<?php
require '../utils/db.php';


try {
    // Prepare the SQL query
    $transactionReport = $conn->prepare("SELECT transactions.*, accounts.name as account, departments.name as department, treasures.name as treasure FROM transactions INNER JOIN accounts ON transactions.account_id = accounts.id INNER JOIN treasures ON transactions.treasure_id = treasures.id INNER JOIN departments ON  transactions.department_id = departments.id");
    $transactionReport->execute();
    $transactions = $transactionReport->fetchAll(PDO::FETCH_ASSOC);

    $totalExpense = 0;
    $totalIncome = 0;
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
                <h3 class="card-title">د معاملاتو راپور</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>تاریخ</th>
                            <th>معاملي ډول</th>
                            <th>تفصیل</th>
                            <th>اکاونټ</th>
                            <th>خزانه / بودجه</th>
                            <th>کریدیت</th>
                            <th>دیبیت</th>
                            <th>څانګه</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction) : ?>

                            <?php

                            $totalExpense += floatval($transaction['debit']);
                            $totalIncome += floatval($transaction['credit']);

                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['credit']) > 0 ? 'عاید' : 'مصرف' ?></td>
                                <td><?php echo htmlspecialchars($transaction['remarks']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['account']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['treasure']); ?></td>
                                <td> <b> <?php echo htmlspecialchars($transaction['credit']) ?? ''; ?> </b></td>
                                <td> <b> <?php echo htmlspecialchars($transaction['debit']) ?? ''; ?> </b></td>
                                <td><?php echo htmlspecialchars($transaction['department']) ?? ''; ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>جمله مصرف</th>
                            <td><?php echo $totalExpense  ?></td>
                            <th>جمله عاید</th>
                            <td><?php echo $totalIncome  ?></td>
                        </tr>
                    </tfoot>
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