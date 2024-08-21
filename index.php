<?php
require './utils/auth_session.php';
require './utils/db.php';


include('./partials/header.php');
include('./partials/navbar.php');
include('./partials/sidebar.php');


try {
    // Prepare the SQL query
    $totalExpenseIncome = $conn->prepare("SELECT SUM(credit) as income , SUM(debit) as expense FROM transactions");
    $totalRenveue = $conn->prepare("SELECT SUM(balance) as revenue FROM treasures");
    $totalTeachers = $conn->prepare("SELECT COUNT(id) as teachers FROM treasures");
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
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo number_format($totalExpenseIncome['income']); ?></h3>

                            <p>جمله عاید</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo number_format($totalExpenseIncome['expense']); ?></h3>

                            <p> جمله مصرف</p>
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
                    <div class="small-box bg-danger">
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