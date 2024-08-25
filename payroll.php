<?php
require './utils/auth_session.php';
require './utils/db.php';

include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');



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


    $teacherStmt = $conn->prepare("SELECT * FROM teachers ");

    $teacherStmt->execute();

    // Fetch all results
    $teachers = $teacherStmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1> د معاشاتو توزیع </h1>
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
                            <h3 class="card-title">توزیع ثبت</h3>
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
                            <form class="row" id="payroll-form" action="actions/create_payroll.php" method="post">
                                <div class="col-12  form-group">
                                    <label for="teacher" class="control-label">ښوونکي </label>
                                    <select type="text" id="teacher" name="teacher" required class="form-control" placeholder="ښوونکي انتخاب *">
                                        <option>د ښوونکي انتخاب</option>
                                        <?php foreach ($teachers as $teacher) : ?>
                                            <option data-salary="<?php echo htmlspecialchars($teacher['salary']) ?>" value="<?php echo htmlspecialchars($teacher['id']); ?>">
                                                <?php echo htmlspecialchars($teacher['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12 ">
                                    <input type="number" id="total_hours" name="total_hours" required class="form-control mt-3" placeholder="کاري ساعتونه  *">
                                </div>
                                <div class="col-12 ">
                                    <input type="number" id="salary" name="salary" required class="form-control mt-3" placeholder="معاش *">
                                </div>
                                <div class="col-12 ">
                                    <input type="number" id="present_days" name="present_days" required class="form-control mt-3" placeholder="حاضر ورځي  *">
                                </div>
                                <div class="col-12 ">
                                    <input type="number" id="absent_days" name="absent_days" required class="form-control mt-3" placeholder="غیر حاضر ورځي  *">
                                </div>
                                <div class="col-6 ">
                                    <input type="number" id="overtime_salary" name="overtime_salary" required class="form-control mt-3" placeholder="اضافه کاري">
                                </div>
                                <div class="col-6 ">
                                    <input type="number" id="net_salary" name="net_salary" required class="form-control mt-3" placeholder="خالص معاش">
                                </div>
                                <div class="col-6 ">
                                    <input type="text" id="year" name="year" required class="form-control mt-3" placeholder="کال">
                                </div>
                                <div class="col-6 ">
                                    <input type="text" id="month" name="month" required class="form-control mt-3" placeholder="میاشت">
                                </div>
                                <div class="col-12 ">
                                    <textarea type="text" id="remarks" name="remarks" class="form-control mt-3" placeholder="توضیحات" rows="3"></textarea>
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
                            <h3 class="card-title">توزیع راپور</h3>
                        </div>
                        <div class="card-header">
                            <div class="row" id="department-div">
                                <div class="col-3">
                                    <a href="printouts/payroll_print.php?search=<?php echo $_GET['search'] ?? '' ?>" target="_blank" class="btn btn-primary btn-block">چاپ</a>
                                </div>

                                <form action="payroll.php" class="row col-7" method="get">
                                    <div class="col-5">
                                        <input type="search" value="<?php echo $_GET['search'] ?? '';  ?>" class="form-control" placeholder="پلټنه ...." name="search" />
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-dark">پلټنه</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
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
                                        <th style="width: 40px">عمليی</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
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
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary edit_payroll" data-id="<?php echo htmlspecialchars($jsonpayroll, ENT_QUOTES, 'UTF-8'); ?>"> تغیر </button>

                                                    <a button class="btn btn-sm btn-secondary" href="actions/delete_payroll.php?id=<?php echo $payroll['id'] ?>" onclick="return confirm('ایا تاسي مطمین یاست?');">حزف</a>
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

        $(document).on('click', '.edit_payroll', function() {
            const params = JSON.parse(this.dataset.id);
            $('#payroll-form').attr('action', 'actions/edit_payroll.php?id=' + params.id);
            $('#teacher').val(params.teacher_id);
            $('#salary').val(params.salary);
            $('#total_hours').val(params.total_hours);
            $('#present_days').val(params.present_days);
            $('#absent_days').val(params.absent_days);
            $('#overtime_salary').val(params.overtime_salary);
            $('#net_salary').val(params.net_salary);
            $('#month').val(params.month);
            $('#year').val(params.year);
            $('#remarks').val(params.remarks);
            $('#submit').text('تغیر');
        });


        $('#teacher').on('change', function() {
            $('#salary').val(this.selectedOptions[0].dataset.salary);
        });

        $("#overtime_salary").on('keyup', function() {
            $('#net_salary').val(Number(this.value) + Number($("#salary").val()))
        })



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

            let rows = $("#body")[0];
            console.log(rows.children)
            rows.forEach((td) => {
                console.log(td)
            })
            return 0;
            _print('printouts/payroll_print.php', {
                body: function() {
                    let _rows = '';

                    return _rows = '';
                }
            })

        })


    });
</script>