<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="../../assets/images/sidebar-logo.png" alt="EStoresExperts Logo" class="brand-image">
        <span class="brand-text font-weight-light">EStoresExperts</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
        if ($_SESSION['profilePicture'] == null) {
        ?>
                <img src="../../assets/images/avatar0.png" alt="User Image"
                    class="img-circle elevation-2 sidebarprofilePicture">
                <?php
        } else {
        ?>
                <img src="../../assets/profiles/<?php echo $_SESSION['profilePicture'] . "?" . time();   ?>"
                    alt="User Image" class="img-circle elevation-2 sidebarprofilePicture">
                <?php
        }
        ?>
            </div>

            <div class="info">
                <span><?php echo $_SESSION['fname']; ?></span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="../dashboard/" class="nav-link" id="navDashboard" onclick="$('.loader').fadeIn();">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li><br>

                <li class="nav-item has-treeview" id="navQuotationTree">
                    <a href="#" class="nav-link" id="navQuotation">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Quotation
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
              <a href="../quotationGenerate/" class="nav-link" id="navQuotation" onclick="$('.loader').fadeIn();">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Generate Quotation
                </p>
              </a>
            </li> -->
                        <li class="nav-item">
                            <a href="../quotationView/" class="nav-link" id="navViewQuotation"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Quotations
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" id="navPosterTree">
                    <a href="#" class="nav-link" id="navPoster">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            Poster
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../posterAdd/" class="nav-link" id="navAddPoster" onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Add Poster
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../posterView/" class="nav-link" id="navViewPoster"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Poster
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" id="navInvoiceTree">
                    <a href="#" class="nav-link" id="navInvoice">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Invoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../invoiceGenerate/" class="nav-link" id="navAddInvoice"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Generate Invoice
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoiceView/" class="nav-link" id="navViewInvoice"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Invoices
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoiceRecurring/" class="nav-link" id="navViewInvoiceRecurring"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Recurring Invoices
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" id="navReminderTree">
                    <a href="#" class="nav-link" id="navReminder">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Reminder
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../reminderAdd/" class="nav-link" id="navAddReminder"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Add reminder
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reminderView/" class="nav-link" id="navViewReminder"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Reminders
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="../attendance/" class="nav-link" id="navAttendance" onclick="$('.loader').fadeIn();">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                            Attendance
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview" id="navQueryTree">
                    <a href="#" class="nav-link" id="navQuery">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Query
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../queryAdd/" class="nav-link" id="navAddQuery" onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Add Query
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../queryView/" class="nav-link" id="navViewQuery" onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Query
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="nav-item">
          <a href="../directory/" class="nav-link" id="navDirectory" onclick="$('.loader').fadeIn();">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              PSC
            </p>
          </a>
        </li> -->

                <li class="nav-item has-treeview" id="navProductTree">
                    <a href="#" class="nav-link" id="navProduct">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../productAdd/" class="nav-link" id="navAddProducts"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Add Services
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../productView/" class="nav-link" id="navViewProducts"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Services
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="../notificationView/" class="nav-link" id="navNotificationView"
                        onclick="$('.loader').fadeIn();">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>
                            Notifications
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview" id="navReportTree">
                    <a href="#" class="nav-link" id="navReport">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../reportAdd/" class="nav-link" id="navAddReport" onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Add Report
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reportView/" class="nav-link" id="navViewReport"
                                onclick="$('.loader').fadeIn();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Report
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <br><br><br>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>