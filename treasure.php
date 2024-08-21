<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM treasures");
    $stmt2 = $conn->prepare("SELECT * FROM accounts");
    $stmt->execute();
    $stmt2->execute();

    // Fetch all results
    $treasures = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $accounts = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> خزانه او اکاونتونه </h1>
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
                            <h3 class="card-title">خزانه ثبت</h3>
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

                            <form class="row" id="treasure-form" action="actions/create_treasure.php" method="post">
                                <div class="col-5">
                                    <input type="text" id="treasure-name" name="name" required class="form-control" placeholder="خزانه نوم *">
                                </div>
                                <div class="col-4">
                                    <input type="number" id="treasure-balance" name="balance" required class="form-control" placeholder="خزاني موجودي *">
                                </div>
                                <div class="col-3">
                                    <button type="submit" id="treasure-submit" class="btn btn-primary btn-block">ثبت</button>
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
                                        <th>موجودي</th>
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($treasures as $treasure) : ?>
                                        <tr style="cursor:pointer" class="treasureRow" data-id="<?php echo htmlspecialchars($treasure['id']); ?>" data-name="<?php echo htmlspecialchars($treasure['name']); ?>" data-balance="<?php echo htmlspecialchars($treasure['balance']); ?>">
                                            <td><?php echo htmlspecialchars($treasure['id']); ?></td>
                                            <td><?php echo htmlspecialchars($treasure['name']); ?></td>
                                            <td><?php echo htmlspecialchars($treasure['balance']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_treasure" data-id="<?php echo implode(',', [$treasure['id'], $treasure['name'], $treasure['balance']]) ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_treasure.php?id=<?php echo $treasure['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">اکاونت ثبت</h3>
                        </div>
                        <div class="card-header">
                            <?php
                            if (isset($_SESSION['account_message'])) :
                            ?>
                                <div class=" alert alert-<?php echo $_SESSION['account_msg_type']; ?> alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php
                                    echo $_SESSION['account_message'];
                                    unset($_SESSION['account_message']);
                                    unset($_SESSION['account_msg_type']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form class="row" id="account-form" action="actions/create_account.php" method="post">
                                <div class="col-5">
                                    <input type="text" id="account-name" name="name" required class="form-control" placeholder="اکاونت نوم *">
                                </div>
                                <div class="col-4">
                                    <select id="account-type" name="type" required class="form-control" placeholder=" ډول *">
                                        <option value="عاید">عاید</option>
                                        <option value="مصرف">مصرف</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button type="submit" id="account-submit" class="btn btn-primary btn-block">ثبت</button>
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
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($accounts as $account) : ?>
                                        <tr style="cursor:pointer" class="accountRow" data-id="<?php echo htmlspecialchars($account['id']); ?>" data-name="<?php echo htmlspecialchars($account['name']); ?>" data-type="<?php echo htmlspecialchars($account['type']); ?>">
                                            <td><?php echo htmlspecialchars($account['id']); ?></td>
                                            <td><?php echo htmlspecialchars($account['name']); ?></td>
                                            <td><?php echo htmlspecialchars($account['type']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_account" data-id="<?php echo implode(',', [$account['id'], $account['name'], $account['type']]) ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_account.php?id=<?php echo $account['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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

        $(document).on('click', '.edit_treasure', function(e) {
            e.stopPropagation();
            const params = this.dataset.id.split(',');
            $('#treasure-form').attr('action', 'actions/edit_treasure.php?id=' + params[0]);
            $('#treasure-name').val(params[1]);
            $('#treasure-balance').val(params[2]);
            $('#treasure-submit').text('تغیر');
        });

        $(document).on('click', '.edit_account', function() {
            const params = this.dataset.id.split(',');
            $('#account-form').attr('action', 'actions/edit_account.php?id=' + params[0]);
            $('#account-name').val(params[1]);
            $('#account-type').val(params[2]);
            $('#account-submit').text('تغیر');
        });

        $('.treasureRow').on('click', function(e) {
            if (e.target.nodeName == 'TD' || e.target.nodeName == 'TR') {
                window.location.href = `treasure_report.php?id=${this.dataset.id}&name=${this.dataset.name}&balance=${this.dataset.balance}`
            }
        })

        $('.accountRow').on('click', function(e) {
            if (e.target.nodeName == 'TD' || e.target.nodeName == 'TR') {
                window.location.href = `account_report.php?id=${this.dataset.id}&name=${this.dataset.name}&type=${this.dataset.type}`
            }
        })
    });
</script>