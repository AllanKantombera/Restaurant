<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy's Restaurant | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assests/css/dashboard.css" rel="stylesheet">

</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <div class="logo">AJ</div>
            <span class="text-light fw-bold">Aunt Joy's Restaurant</span>
        </a>

        <div class="d-flex">
            <span class="text-light me-3">Admin User</span>
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link " href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>
                
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="reports.php">
                            <i class="bi bi-graph-up me-2"></i> Reports
                        </a>
                    </li>
                
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="reportsExport.php">
                            <i class="bi bi-download me-2"></i> Export Reports
                        </a>
                    </li>

                </ul>
            </div>



            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Reports & Exports</h2>
                    <div class="text-light small" id="currentDate"></div>
                </div>

                <!-- Custom Export Section -->
                <div class="card card-custom p-4">
                    <h4 class="section-title mb-4">Custom Report Export</h4>

                    <div class="row g-4">
                        <!-- Report Type -->
                        <div class="col-md-6">
                            <label class="form-label" style="color: #dce7f5;">Report Type</label>
                            <select class="form-select"
                                style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;">
                                <option value="">Select Report Type</option>
                                <option value="sales">Sales Report</option>
                                <option value="orders">Orders Report</option>
                                <option value="inventory">Inventory Report</option>
                                <option value="customers">Customer Analytics</option>
                                <option value="staff">Staff Performance</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="col-md-6">
                            <label class="form-label" style="color: #dce7f5;">Date Range</label>
                            <select class="form-select"
                                style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="week">This Week</option>
                                <option value="month" selected>This Month</option>
                                <option value="quarter">This Quarter</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>

                        <!-- Export Format -->
                        <div class="col-md-6">
                            <label class="form-label" style="color: #dce7f5;">Export Format</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exportFormat" id="pdfFormat"
                                        checked>
                                    <label class="form-check-label" style="color: #dce7f5;" for="pdfFormat">
                                        <i class="bi bi-file-pdf text-danger me-1"></i>PDF
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exportFormat" id="excelFormat">
                                    <label class="form-check-label" style="color: #dce7f5;" for="excelFormat">
                                        <i class="bi bi-file-spreadsheet text-success me-1"></i>Excel
                                    </label>
                                </div>
                            </div>
                        </div>

                      
                        <!-- Generate Button -->
                        <div class="col-12">
                            <button class="btn btn-primary">
                                <i class="bi bi-download me-2"></i>Generate & Download Report
                            </button>
                        </div>
                    </div>
                </div>


            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>