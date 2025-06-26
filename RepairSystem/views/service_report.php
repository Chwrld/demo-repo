<?php
require_once '../handlers/service_report_handler.php';
require_once '../handlers/customer_handler.php';
require_once '../handlers/appliance_handler.php';
require_once '../handlers/staff_handler.php';
require_once '../handlers/parts_handler.php';

$service_report_handler = new ServiceReportHandler();
$customer_handler = new CustomerHandler();
$appliance_handler = new ApplianceHandler();
$staff_handler = new StaffHandler();
$parts_handler = new PartsHandler();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_report'])) {
        $report_id = $service_report_handler->createServiceReport(
            $_POST['customer'],
            $_POST['appliance'],
            $_POST['technician'],
            $_POST['date_in'],
            $_POST['service_type'],
            $_POST['complaint'],
            $_POST['parts'] ?? [],
            $_POST['quantities'] ?? []
        );
        
        if ($report_id) {
            echo "<script>alert('Service report created successfully');</script>";
        } else {
            echo "<script>alert('Error creating service report');</script>";
        }
    }
    
    if (isset($_POST['update_status'])) {
        $success = $service_report_handler->updateServiceReport(
            $_POST['report_id'],
            $_POST['status'],
            $_POST['date_repaired'],
            $_POST['date_delivered'],
            $_POST['cost']
        );
        
        if ($success) {
            echo "<script>alert('Service report updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating service report');</script>";
        }
    }
}

// Get all customers for dropdown
$customers = $customer_handler->getAllCustomers();

// Get technicians for dropdown
$technicians = $staff_handler->getTechnicians();

// Get all parts for dropdown
$parts = $parts_handler->getAllParts();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Report</title>
    <link rel="shortcut Icon" href="../img/Repair.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="../img/Repair.png" class="img-fluid"/><span>Repair Service</span></h3>
            </div>
            <ul class="list-unstyled components">
                <li><a href="home.php"><i class="material-icons">dashboard</i><span>Dashboard</span></a></li>
                <li><a href="customer_info.php"><i class="material-icons">people</i><span>Customer Info</span></a></li>
                <li class="active"><a href="service_report.php"><i class="material-icons">description</i><span>Service report</span></a></li>
                <li><a href="parts.php"><i class="material-icons">build</i><span>Parts</span></a></li>
                <li><a href="transactions.php"><i class="material-icons">payment</i><span>Transactions</span></a></li>
                <li><a href="staff.php"><i class="material-icons">engineering</i><span>Staff</span></a></li>
            </ul>
        </nav>

        <div id="content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div class="xp-topbar">
                    <div class="row"> 
                        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                            <div class="xp-menubar">
                                <span class="material-icons text-white">signal_cellular_alt</span>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-3 order-3 order-md-2">
                            <div class="xp-searchbar">
                                <form>
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn" type="submit" id="button-addon2">GO</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xp-breadcrumbbar text-center">
                    <h4 class="page-title">Service Report</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Service Report</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Service Report Form</h5>
                                <button type="button" class="btn btn-light px-4" data-toggle="modal" data-target="#serviceReportListModal"><i class="material-icons align-middle">list</i> <span class="align-middle">List</span></button>
                            </div>
                            <div class="card-body">
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="container-fluid">
                                        <!-- First Row: Customer, Appliance, Date In, Status -->
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label>Customer</label>
                                                <input type="text" class="form-control" name="customer" placeholder="Enter Name">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Appliance</label>
                                                <select class="form-control" name="appliance">
                                                    <option>Select Appliance</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Date In</label>
                                                <input type="date" class="form-control" name="date_in">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Status</label>
                                                <select class="form-control" name="status">
                                                    <option>Select Status</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Second Row: Dealer, DOP, Date Pulled-Out, Service Type -->
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label>Dealer</label>
                                                <input type="text" class="form-control" name="dealer">
                                            </div>
                                            <div class="col-md-3">
                                                <label>DOP</label>
                                                <input type="text" class="form-control" name="dop">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Date Pulled - Out</label>
                                                <input type="date" class="form-control" name="date_pulled_out">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Service Type</label>
                                                <select class="form-control" name="service_type">
                                                    <option>Select Service Type</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Findings with Shop/Field/Out WTY labels aligned right, checkboxes below -->
                                        <div class="row mb-0">
                                            <div class="col-md-9">
                                                <label>Findings</label>
                                            </div>
                                            <div class="col-md-auto text-center">
                                                <label class="form-label p-0 m-0" style="font-weight: normal;">Shop</label>
                                            </div>
                                            <div class="col-md-auto text-center">
                                                <label class="form-label p-0 m-0" style="font-weight: normal;">Field</label>
                                            </div>
                                            <div class="col-md-auto text-center">
                                                <label class="form-label p-0 m-0" style="font-weight: normal;">Out WTY</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="findings">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <input class="form-check-input mt-0" type="checkbox" name="shop" id="shop">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <input class="form-check-input mt-0" type="checkbox" name="field" id="field">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <input class="form-check-input mt-0" type="checkbox" name="out_wty" id="out_wty">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <label>Remarks</label>
                                                <input type="text" class="form-control" name="remarks">
                                            </div>
                                        </div>
                                        <!-- Part Used Section Header -->
                                        <div class="row mb-1 mt-3">
                                            <div class="col-md-12">
                                                <h5 class="fw-bold mb-1">Part Used</h5>
                                            </div>
                                        </div>
                                        <!-- Part Used Row with Buttons -->
                                        <div class="row mb-2 align-items-center g-2">
                                            <div class="col-md-3 pe-1">
                                                <select class="form-control" name="part_used">
                                                    <option>Select Part</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 px-1">
                                                <input type="number" class="form-control" name="quantity" placeholder="Quantity">
                                            </div>
                                            <div class="col-md-2 px-1">
                                                <input type="number" class="form-control" name="amount" placeholder="Amount">
                                            </div>
                                            <div class="col-md-1 px-1 text-end">
                                                <button type="button" class="btn btn-danger"><i class="material-icons">remove</i></button>
                                            </div>
                                            <div class="col-md-2 ps-1">
                                                <button type="button" class="btn btn-primary w-100"><i class="material-icons">add</i> Add Part</button>
                                            </div>
                                        </div>
                                        <!-- Checkboxes Row -->
                                        <div class="row mb-2">
                                            <div class="col-md-12 d-flex align-items-center" style="gap: 2.5rem;">
                                                <div class="form-check d-flex align-items-center" style="gap: 0.5rem;">
                                                    <input class="form-check-input" type="checkbox" name="installation" id="installation">
                                                    <label class="form-check-label mb-0" for="installation">Installation</label>
                                                </div>
                                                <div class="form-check d-flex align-items-center" style="gap: 0.5rem;">
                                                    <input class="form-check-input" type="checkbox" name="repair" id="repair">
                                                    <label class="form-check-label mb-0" for="repair">Repair</label>
                                                </div>
                                                <div class="form-check d-flex align-items-center" style="gap: 0.5rem;">
                                                    <input class="form-check-input" type="checkbox" name="cleaning" id="cleaning">
                                                    <label class="form-check-label mb-0" for="cleaning">Cleaning</label>
                                                </div>
                                                <div class="form-check d-flex align-items-center" style="gap: 0.5rem;">
                                                    <input class="form-check-input" type="checkbox" name="checkup" id="checkup">
                                                    <label class="form-check-label mb-0" for="checkup">Check-Up</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Total Amount and Date Repaired Row -->
                                        <div class="row mb-2">
                                            <div class="col-md-8 pe-1">
                                                <label>Total Amount</label>
                                                <div class="input-group mb-0">
                                                    <span class="input-group-text">₱</span>
                                                    <input type="text" class="form-control" name="total_amount" value="13,000">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ps-1">
                                                <label>Date Repaired</label>
                                                <input type="date" class="form-control" name="date_repaired">
                                            </div>
                                        </div>
                                        <!-- Complaint and Date Delivered Row -->
                                        <div class="row mb-2">
                                            <div class="col-md-8 pe-1">
                                                <label>Complaint</label>
                                                <textarea class="form-control" name="complaint" rows="2"></textarea>
                                            </div>
                                            <div class="col-md-4 ps-1">
                                                <label>Date Delivered</label>
                                                <input type="date" class="form-control" name="date_delivered">
                                            </div>
                                        </div>
                                        <!-- Charged Details Section Header -->
                                        <div class="row mt-3 mb-1">
                                            <div class="col-md-12">
                                                <h5 class="fw-bold mb-1">Charged Details</h5>
                                            </div>
                                        </div>
                                        <!-- Charged Details Row -->
                                        <div class="row mb-2 align-items-end">
                                            <div class="col-md-3 pe-1">
                                                <label>Labor:</label>
                                                <input type="text" class="form-control" name="labor">
                                            </div>
                                            <div class="col-md-3 px-1">
                                                <label>Pull-Out Delivery:</label>
                                                <input type="text" class="form-control" name="pullout_delivery">
                                            </div>
                                            <div class="col-md-3 px-1">
                                                <label>Total:</label>
                                                <input type="text" class="form-control" name="total">
                                            </div>
                                            <div class="col-md-3 ps-1">
                                                <label>Parts Charge:</label>
                                                <input type="text" class="form-control" name="parts_charge">
                                            </div>
                                        </div>
                                        <!-- Signature Fields Row -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="receptionist" placeholder="Receptionist">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="supervisor" placeholder="Supervisor">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="technician" placeholder="Technician">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="released_by" placeholder="Released By:">
                                            </div>
                                        </div>
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-end mt-3" style="gap: 1.5rem;">
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                            <button type="submit" class="btn btn-primary" style="background-color: #0066e6; border: none;">Submit Report</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Report Modal -->
                <div class="modal fade" id="editReportModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="modal-header">
                                    <h4 class="modal-title">Update Service Report</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="report_id" id="edit_report_id">
                                    <!-- Add form fields similar to the create form -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" id="edit_status" class="form-control" required>
                                                    <option value="Pending">Pending</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cost</label>
                                                <input type="number" name="cost" id="edit_cost" class="form-control" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date Repaired</label>
                                                <input type="date" name="date_repaired" id="edit_date_repaired" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date Delivered</label>
                                                <input type="date" name="date_delivered" id="edit_date_delivered" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Service Report List Modal -->
                <div class="modal fade" id="serviceReportListModal" tabindex="-1" aria-labelledby="serviceReportListModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 90%;">
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-header" style="border-bottom: 2px solid #2196f3;">
                                <h6 class="modal-title fw-bold" id="serviceReportListModalLabel">Service Report List</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-0" style="padding: 1.5rem 1.5rem 1rem 1.5rem !important;">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Report ID</th>
                                                <th>Customer</th>
                                                <th>Appliance</th>
                                                <th>Service Type</th>
                                                <th>Date In</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $reports = $service_report_handler->getAllServiceReports();
                                            if ($reports && $reports->num_rows > 0) {
                                                while($row = $reports->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row["ReportID"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["CustomerName"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["ApplianceName"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Service_type"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Date_In"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Status"]) . "</td>";
                                                    echo "<td>₱" . number_format($row["Cost"], 0) . "</td>";
                                                    echo '<td><a href="#" class="me-2"><i class="material-icons text-primary">edit</i></a><a href="#"><i class="material-icons text-danger">delete</i></a></td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo '<tr><td colspan="8" class="text-center">No service reports found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Report List Modal -->

                <!-- Footer -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="footer-in">
                            <p class="mb-0">2025 Repair Service - Ranes, Angelo C., Palen, Andrew E., Omega, Angel Andrea B.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Toggle Sidebar
            $(".xp-menubar").on('click',function() {
                $("#sidebar").toggleClass('active');
                $("#content").toggleClass('active');
            });

            // Customer Change Event
            $('select[name="customer"]').change(function() {
                var customerId = $(this).val();
                if(customerId) {
                    $.ajax({
                        url: '../handlers/get_customer_appliances.php',
                        type: 'POST',
                        data: {customer_id: customerId},
                        success: function(data) {
                            $('select[name="appliance"]').html(data);
                        }
                    });
                }
            });

            // Parts Management
            $('#add-part').click(function() {
                var newRow = $('.parts-row').first().clone();
                newRow.find('select').val('');
                newRow.find('input').val('');
                $('#parts-container').append(newRow);
            });

            $(document).on('click', '.remove-part', function() {
                if($('.parts-row').length > 1) {
                    $(this).closest('.parts-row').remove();
                }
            });

            $(document).on('change', '.part-select, .quantity-input', function() {
                var row = $(this).closest('.parts-row');
                var partSelect = row.find('.part-select');
                var quantity = row.find('.quantity-input').val();
                var price = partSelect.find(':selected').data('price');

                if(quantity && price) {
                    var subtotal = quantity * price;
                    row.find('.subtotal').val('$' + subtotal.toFixed(2));
                } else {
                    row.find('.subtotal').val('');
                }
            });

            // Set data for edit report modal
            $('.edit-report').click(function(){
                const reportId = $(this).data('id');
                $('#edit_report_id').val(reportId);
                
                // Load report details via AJAX
                $.ajax({
                    url: '../handlers/get_service_report.php',
                    type: 'GET',
                    data: { report_id: reportId },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit_status').val(response.Status);
                        $('#edit_cost').val(response.Cost);
                        $('#edit_date_repaired').val(response.Date_Repaired);
                        $('#edit_date_delivered').val(response.Date_Delivered);
                    }
                });
            });
        });
    </script>
</body>
</html>