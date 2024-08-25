<?php
require './utils/auth_session.php';
require './utils/db.php';


include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');


try {
    // Prepare the SQL query
    $totalExpenseIncome = $conn->prepare(
        "SELECT
            SUM(credit) as total_income ,
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN credit ELSE 0 END) AS daily_income,
            SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN credit ELSE 0 END) AS monthly_income,
            SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN credit ELSE 0 END) AS yearly_income,
            SUM(debit) as total_expense,
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN debit ELSE 0 END) AS daily_expense,
            SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN debit ELSE 0 END) AS monthly_expense,
            SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN debit ELSE 0 END) AS yearly_expense
        FROM transactions"
    );
    $totalRenveue = $conn->prepare("SELECT SUM(balance) as revenue FROM treasures");
    $totalTeachers = $conn->prepare("SELECT COUNT(id) as teachers FROM teachers");
    $totalExpenseIncome->execute();
    $totalRenveue->execute();
    $totalTeachers->execute();

    // Fetch all results
    $totalExpenseIncome = $totalExpenseIncome->fetchAll(PDO::FETCH_ASSOC)[0];
    $totalRenveue = $totalRenveue->fetchAll(PDO::FETCH_ASSOC)[0];
    $totalTeachers = $totalTeachers->fetchAll(PDO::FETCH_ASSOC)[0];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">عمومي صفحه</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p>جمله عاید</p>
                            <h3 id="income"><?php echo number_format($totalExpenseIncome['total_income']); ?></h3>
                        </div>
                        <div class="inner">
                            <p>ورځنی عاید</p>
                            <h3 id="income"><?php echo number_format($totalExpenseIncome['daily_income']); ?></h3>
                        </div>
                        <div class="inner">
                            <p>میاشتنی عاید</p>
                            <h3 id="income"><?php echo number_format($totalExpenseIncome['monthly_income']); ?></h3>
                        </div>
                        <div class="inner">
                            <p>کلنی عاید</p>
                            <h3 id="income"><?php echo number_format($totalExpenseIncome['yearly_income']); ?></h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p> جمله مصرف</p>

                            <h3><?php echo number_format($totalExpenseIncome['total_expense']); ?></h3>
                        </div>
                        <div class="inner">
                            <p> ورځنی مصرف</p>

                            <h3><?php echo number_format($totalExpenseIncome['daily_expense']); ?></h3>
                        </div>
                        <div class="inner">
                            <p> میاشتنی مصرف</p>

                            <h3><?php echo number_format($totalExpenseIncome['monthly_expense']); ?></h3>
                        </div>
                        <div class="inner">
                            <p> کلنی مصرف</p>

                            <h3><?php echo number_format($totalExpenseIncome['yearly_expense']); ?></h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo number_format($totalRenveue['revenue']); ?></h3>
                            <p> اوسنی بودجه</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo number_format($totalTeachers['teachers']); ?></h3>
                            <p>ټول استادان</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php include('./partials/footer.php'); ?>