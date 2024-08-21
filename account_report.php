<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



try {
    $id = $_GET['id'];

    // Prepare the SQL query
    $transactionReport = $conn->prepare("SELECT transactions.*, accounts.name as account, departments.name as department, treasures.name as treasure FROM transactions INNER JOIN accounts ON transactions.account_id = accounts.id INNER JOIN treasures ON transactions.treasure_id = treasures.id INNER JOIN departments ON  transactions.department_id = departments.id WHERE account_id = :id");
    $transactionReport->bindParam(':id', $id);

    $transactionReport->execute();
    $transactions = $transactionReport->fetchAll(PDO::FETCH_ASSOC);

    $totalExpense = 0;
    $totalIncome = 0;
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
                    <h1> د اکاونټ راپور</h1>
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
                            <div class="card-title" style="display:flex">
                                <div class="ml-4"><b>اکاونټ : </b> <span><?php echo $_GET['name']; ?></span></div>
                                <div class="ml-5 mr-5"><b>ډول :</b> <span><?php echo $_GET['type']; ?></span></div>
                                <button id="print" class="btn mr-5 btn-primary">چاپ</button>

                            </div>

                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead id="header">
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
                                <tbody id="body">
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





        function closePrint() {
            document.body.removeChild(this.__container__)
        }

        function setPrint(str) {
            this.contentWindow.__container__ = this
            this.contentWindow.document.getElementById("body").innerHTML = str
            this.contentWindow.onbeforeunload = closePrint
            this.contentWindow.onafterprint = closePrint
            this.contentWindow.focus()
            this.contentWindow.print()
        }

        function _print(curl, Data) {
            var iframe = document.createElement("iframe")
            iframe.onload = function() {
                this.contentWindow.__container__ = this
                for (const key in Data) {
                    if (Object.hasOwnProperty.call(Data, key)) {
                        this.contentWindow.document.getElementById(key).innerHTML = typeof Data[key] == 'function' ? Data[key]() : Data[key]
                    }
                }
                this.contentWindow.onbeforeunload = closePrint
                this.contentWindow.onafterprint = closePrint
                this.contentWindow.focus()
                this.contentWindow.print()
            }
            iframe.style.position = "fixed"
            iframe.style.bottom = "0"
            iframe.style.right = "0"
            iframe.style.width = "0"
            iframe.style.height = "0"
            iframe.style.border = "0"
            iframe.src = curl
            document.body.appendChild(iframe)
        }
        $("#print").click(function(e) {
            e.preventDefault();


            _print('printouts/payroll_print.php', {
                header: document.getElementById('header').innerHTML,
                body: function() {
                    var _rows = '';
                    $('#body tr').each(function() {
                        // `this` refers to the current <tr> element
                        _rows += '<tr>';
                        $(this).find('td').each(function() {
                            _rows += `<td>${$(this).text()}</td>`;
                        });

                        _rows += '</tr>';
                    });
                    return _rows;
                },
                title: ` ${ "<?php echo $_GET['name']; ?>" } د معاملاتو راپور`
            })

        })


    });
</script>