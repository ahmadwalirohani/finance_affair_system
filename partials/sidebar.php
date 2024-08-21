<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"> مالي سیستم</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        <?php echo $_SESSION['username'] ?>
                    </a>
                </div>
                <button onclick="window.location.href = 'logout.php'" class="btn btn-primary btn-sm" style="margin-right:20px">وتل</button>
            </div>

            <!-- Sidebar Menu -->
            <div class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="index.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'index' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                عمومي صفحه
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="treasure.php" class="nav-link <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'treasure' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>

                                خزانه او اکاونتونه
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="transaction.php" class="nav-link <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'transaction' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                معاملات
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="items.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'items' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                اجناس
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="item_request.php" class="nav-link <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'item_request' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                اجناس ارډر
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="item_dedication.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'item_dedication' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                اجناس تسلیمي
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="teachers.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'teachers' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                استاذان
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payroll.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'payroll' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                معاشاتو توزیع
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departments.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'departments' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                څانګي
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="user.php" class="nav-link  <?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'user' ? 'active' : ''  ?>">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                یوزر تنظیم
                            </p>
                        </a>
                    </li>
                </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
</aside>