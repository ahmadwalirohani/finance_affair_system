<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $transactionReport = $conn->prepare("SELECT transactions.*, accounts.name as account, departments.name as department, treasures.name as treasure FROM transactions INNER JOIN accounts ON transactions.account_id = accounts.id INNER JOIN treasures ON transactions.treasure_id = treasures.id INNER JOIN departments ON  transactions.department_id = departments.id");
    $transactionReport->execute();
    $transactions = $transactionReport->fetchAll(PDO::FETCH_ASSOC);

    $totalExpense = 0;
    $totalIncome = 0;



    $DepartmentsSstmt = $conn->prepare("SELECT * FROM departments");
    $AccountStmt = $conn->prepare("SELECT * FROM accounts ");
    $TreasureStmt = $conn->prepare("SELECT * FROM treasures");

    $DepartmentsSstmt->execute();
    $AccountStmt->execute();
    $TreasureStmt->execute();

    // Fetch all results
    $departments = $DepartmentsSstmt->fetchAll(PDO::FETCH_ASSOC);
    $accounts = $AccountStmt->fetchAll(PDO::FETCH_ASSOC);
    $treasures = $TreasureStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection
?>
<style>
    table {
        /* display: block;
        overflow-x: auto;
        white-space: nowrap; */
        overflow: scroll;
    }

    .card-body {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    /* 
    table tbody {
        display: table;
        width: 100%;
    }

    table thead {
        display: table;
        width: 100%;
    } */
</style>
<div class="content-wrapper" style="min-height: 768.666px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> معلاملات </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">معاملي ثبت</h3>
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


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="row" id="transaction-form" action="actions/create_transaction.php" method="post">
                                <div class="col-12  form-group">
                                    <label for="account" class="control-label">اکاونټ </label>
                                    <select type="text" id="account" name="account" required class="form-control" placeholder="اکاونټ انتخاب *">
                                        <option>د اکاونټ انتخاب</option>
                                        <?php foreach ($accounts as $account) : ?>
                                            <option value="<?php echo htmlspecialchars($account['id']); ?>">
                                                <?php echo htmlspecialchars($account['name']); ?> &nbsp;&nbsp;&nbsp;
                                                <span style="color=red"><?php echo htmlspecialchars($account['type']); ?></span>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12  form-group">
                                    <label for="treasure" class="control-label">خزانه / بودجه </label>
                                    <select type="text" id="treasure" name="treasure" required class="form-control" placeholder="خزاني / بودجي انتخاب *">
                                        <option>د خزاني / بودجي انتخاب</option>
                                        <?php foreach ($treasures as $treasure) : ?>
                                            <option value="<?php echo htmlspecialchars($treasure['id']); ?>">
                                                <?php echo htmlspecialchars($treasure['name']); ?> &nbsp;&nbsp;&nbsp;
                                                <code><?php echo htmlspecialchars($treasure['balance']); ?></code>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12  form-group">
                                    <label for="department" class="control-label">څانګه </label>
                                    <select required type="text" id="department" name="department" required class="form-control" placeholder="څانګه انتخاب *">
                                        <option>د څانګه انتخاب</option>
                                        <?php foreach ($departments as $department) : ?>
                                            <option value="<?php echo htmlspecialchars($department['id']); ?>"><?php echo htmlspecialchars($department['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12 ">
                                    <label for="amount" class="control-label">مبلغ </label>
                                    <input type="number" id="amount" name="amount" required class="form-control" placeholder="مبلغ  *">
                                </div>
                                <div class="col-12 ">
                                    <label for="remarks" class="control-label">توضیحات </label>
                                    <textarea type="text" id="remarks" name="remarks" class="form-control" placeholder="توضیحات" rows="3"></textarea>
                                </div>
                                <div class="col-12 mt-3 ">
                                    <button type="submit" id="submit" class="btn btn-primary btn-block">ثبت</button>
                                </div>
                            </form>

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">معاملي راپور</h3>
                        </div>
                        <div class="card-header">
                            <div class="row" id="department-div">
                                <div class="col-3">
                                    <a href="printouts/transactions_print.php" target="_blank" id="print" class="btn btn-primary btn-block">چاپ</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:">#</th>
                                        <th>تاریخ</th>
                                        <th>معاملي ډول</th>
                                        <th>تفصیل</th>
                                        <th>اکاونټ</th>
                                        <th>خزانه / بودجه</th>
                                        <th>کریدیت</th>
                                        <th>دیبیت</th>
                                        <th>څانګه</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>

                                        <?php

                                        $totalExpense += floatval($transaction['debit']);
                                        $totalIncome += floatval($transaction['credit']);

                                        $jsonTransaction = json_encode($transaction, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
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
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_transaction" data-id="<?php echo htmlspecialchars($jsonTransaction, ENT_QUOTES, 'UTF-8'); ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_transaction.php?id=<?php echo $transaction['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
                                                </div>
                                            </td>
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
                    <!-- /.card -->

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<?php include('./partials/footer.php'); ?>
<!-- DataTables -->
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

        $(document).on('click', '.edit_transaction', function() {
            const params = JSON.parse(this.dataset.id);
            $('#transaction-form').attr('action', 'actions/edit_transaction.php?id=' + params.id);
            $('#account').val(params.account_id);
            $('#department').val(params.department_id);
            $('#treasure').val(params.treasure_id);
            $('#amount').val(Number(params.credit) > 0 ? params.credit : params.debit);
            $('#remarks').val(params.remarks);
            $('#submit').text('تغیر');
        });




    });
</script>