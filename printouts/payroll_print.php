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
                <h3 id="title" class="card-title">د معاملاتو راپور</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead id="header">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="body">

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