<?php
session_start(); // Start the session at the beginning

// Initialize variables with default values
$cryptoDepositSuccess = false;
$profitCalculationResult = null;
$withdrawalRequestSuccess = false;

// Check if the user is logged in
$isLoggedIn = isset($_SESSION["email"]);
$userName = $isLoggedIn ? htmlspecialchars($_SESSION["email"]) : '';

// Handle logout if logout link is clicked
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: .././index.html');
    exit();
}

// Example processing of form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle cryptocurrency deposit
    if (isset($_POST['cryptoDeposit'])) {
        $cryptoAmount = $_POST['cryptoAmount'];
        // Process deposit logic here (e.g., validate amount, update database)
        // Set success message
        $cryptoDepositSuccess = "Deposited $cryptoAmount BTC successfully!";
    }
    
    // Handle profit calculation
    if (isset($_POST['profitCalculator'])) {
        $investmentAmount = $_POST['investmentAmount'];
        $profitPercentage = $_POST['profitPercentage'];
        // Calculate profit
        $profitCalculationResult = $investmentAmount * ($profitPercentage / 100);
    }

    // Handle withdrawal request
    if (isset($_POST['withdrawalRequest'])) {
        $withdrawalAmount = $_POST['withdrawalAmount'];
        // Process withdrawal request here (e.g., validate amount, update database)
        // Set success message
        $withdrawalRequestSuccess = "Withdrawal request for $withdrawalAmount BTC was successful!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .card {
            background-color: #F7931A; /* Bitcoin Orange */
            color: #FFFFFF; /* White */
            margin: 15px 0; /* Margin between cards */
            padding: 20px; /* Padding inside cards */
            border-radius: 10px; /* Rounded corners */
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .col-xl-3, .col-md-6 {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Bitcoin America</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="?action=logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.php">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.php">Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.php">Login</a>
                                        <a class="nav-link" href="register.php">Register</a>
                                        <a class="nav-link" href="password.php">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.php">401 Page</a>
                                        <a class="nav-link" href="404.php">404 Page</a>
                                        <a class="nav-link" href="500.php">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <?php if ($isLoggedIn): ?>
                        <div class="small">Logged in as:</div>
                        <?php echo htmlspecialchars($userName); ?>
                    <?php else: ?>
                        <div class="small">Not logged in</div>
                    <?php endif; ?>
                </div>
            </nav>
        </div>


            
            <div id="layoutSidenav_content">
                <body>
                <main>
                <div class="container-fluid px-4">
                   
                    <div class="row">
                        <!-- Crypto Deposit Card -->
                        <div class="col-xl-3 col-md-6">
    <div class="card bg-bitcoin-orange text-white equal-height">
        <div class="card-body">
            <h5 class="card-title">Deposit Cryptocurrency</h5>
            <?php if ($cryptoDepositSuccess): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($cryptoDepositSuccess); ?></div>
            <?php endif; ?>
            <form method="post" id="cryptoDepositForm">
                <div class="mb-3">
                    <label for="cryptoAmount" class="form-label">Amount (BTC)</label>
                    <input type="number" name="cryptoAmount" class="form-control" id="cryptoAmount" placeholder="Enter amount" required>
                </div>
                <button type="submit" name="cryptoDeposit" class="btn btn-light">Deposit</button>
            </form>
        </div>
    </div>
</div>

<!-- Investment Details Card -->
<div class="col-xl-3 col-md-6">
    <div class="card bg-bitcoin-dark text-white equal-height">
        <div class="card-body">
            <h5 class="card-title">Investment Details</h5>
            <p id="investmentDetails">Investment Amount: $0<br>Asset: BTC<br>Earnings: $0</p>
        </div>
    </div>
</div>

<!-- Profit Calculator Card -->
<div class="col-xl-3 col-md-6">
    <div class="card bg-bitcoin-orange text-white equal-height">
        <div class="card-body">
            <h5 class="card-title">Profit Calculator</h5>
            <?php if ($profitCalculationResult !== null): ?>
                <p id="profitResult" class="mt-3"><?php echo htmlspecialchars($profitCalculationResult); ?></p>
            <?php endif; ?>
            <form method="post" id="profitCalculatorForm">
                <div class="mb-3">
                    <label for="investmentAmount" class="form-label">Investment Amount</label>
                    <input type="number" name="investmentAmount" class="form-control" id="investmentAmount" placeholder="Enter amount" required>
                </div>
                <div class="mb-3">
                    <label for="profitPercentage" class="form-label">Profit Percentage</label>
                    <input type="number" name="profitPercentage" class="form-control" id="profitPercentage" placeholder="Enter percentage" required>
                </div>
                <button type="submit" name="profitCalculator" class="btn btn-light">Calculate</button>
            </form>
        </div>
    </div>
</div>

<!-- Withdrawal Request Card -->
<div class="col-xl-3 col-md-6">
    <div class="card bg-bitcoin-dark text-white equal-height">
        <div class="card-body">
            <h5 class="card-title">Withdrawal Request</h5>
            <?php if ($withdrawalRequestSuccess): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($withdrawalRequestSuccess); ?></div>
            <?php endif; ?>
            <form method="post" id="withdrawalRequestForm">
                <div class="mb-3">
                    <label for="withdrawalAmount" class="form-label">Amount (BTC)</label>
                    <input type="number" name="withdrawalAmount" class="form-control" id="withdrawalAmount" placeholder="Enter amount" required>
                </div>
                <button type="submit" name="withdrawalRequest" class="btn btn-light">Request Withdrawal</button>
            </form>
        </div>
    </div>
</div>


                    <!-- Charts and DataTable -->
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Area Chart Example
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Location</th>
                                        <th>Age</th>
                                        <th>Date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
                
                    <style>
                        /* Set the height of all cards to be the same */
                        .equal-height {
                            display: flex;
                            flex-direction: column;
                            height: 100%;
                        }
                
                        /* Bitcoin Colors */
                        .bg-bitcoin-orange {
                            background-color: #f7931a;
                        }
                
                        .bg-bitcoin-dark {
                            background-color: #4d4d4e;
                        }
                    </style>
                
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                                <div>
                                    <a href="#">Privacy Policy</a>
                                    &middot;
                                    <a href="#">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                    <script src="js/scripts.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
                    <script src="assets/demo/chart-area-demo.js"></script>
                    <script src="assets/demo/chart-bar-demo.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
                    <script src="js/datatables-simple-demo.js"></script>
                
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // Handle Crypto Deposit Form
                            document.getElementById('cryptoDepositForm').addEventListener('submit', function(event) {
                                event.preventDefault();
                                const amount = parseFloat(document.getElementById('cryptoAmount').value);
                                if (!isNaN(amount) && amount > 0) {
                                    // Simulate deposit operation
                                    // alert(`Deposited ${amount} BTC successfully!`);
                                    // Update investment details
                                    document.getElementById('investmentDetails').innerHTML = `Investment Amount: $${amount * 50000} (approx)<br>Asset: BTC<br>Earnings: $0`;
                                } else {
                                    alert('Please enter a valid amount.');
                                }
                            });
                
                            // Handle Profit Calculator Form
                            document.getElementById('profitCalculatorForm').addEventListener('submit', function(event) {
                                event.preventDefault();
                                const amount = parseFloat(document.getElementById('investmentAmount').value);
                                const percentage = parseFloat(document.getElementById('profitPercentage').value);
                                if (!isNaN(amount) && !isNaN(percentage) && amount > 0 && percentage >= 0) {
                                    const profit = (amount * (percentage / 100)).toFixed(2);
                                    document.getElementById('profitResult').innerText = `Profit: $${profit}`;
                                } else {
                                    alert('Please enter valid values.');
                                }
                            });
                
                            // Handle Withdrawal Request Form
                            document.getElementById('withdrawalRequestForm').addEventListener('submit', function(event) {
                                event.preventDefault();
                                const amount = parseFloat(document.getElementById('withdrawalAmount').value);
                                if (!isNaN(amount) && amount > 0) {
                                    // Simulate withdrawal operation
                                    alert(`Withdrawal request of ${amount} BTC submitted!`);
                                } else {
                                    alert('Please enter a valid amount.');
                                }
                            });
                
                            // Show modal on deposit button click
                            document.querySelector('#cryptoDepositForm button').addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent form submission
                                new bootstrap.Modal(document.getElementById('depositModal')).show();
                            });
                        });
                
                        // Function to copy Bitcoin address to clipboard
                        function copyAddress() {
                            const address = document.getElementById('bitcoinAddress');
                            address.select();
                            document.execCommand('copy');
                            alert('Address copied to clipboard');
                        }
                    </script>
                
                    <!-- Deposit Modal -->
                    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="depositModalLabel">Deposit Bitcoin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="bitcoin.png" alt="Bitcoin Wallet" class="img-fluid mb-3" />
                                    <p class="text-center">Scan the QR code or download the image to deposit Bitcoin to the address below:</p>
                                    <div class="mb-3">
                                        <input type="text" class="form-control mb-2" id="bitcoinAddress" value="1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa" readonly />
                                        <button class="btn btn-primary mb-2" onclick="copyAddress()">Copy Address</button>
                                        <a href="bitcoin.png" download="bitcoin.png" class="btn btn-success">Download QR Code</a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                
</html>
