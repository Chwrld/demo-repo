<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Repair Service</title>
    <link rel="shortcut Icon" href="img/Repair.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="d-flex align-items-center" style="min-height: 100vh; background: rgb(74, 82, 99);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-5">
                <div class="card shadow-sm border-0 mt-5" style="border-radius: 1.5rem;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="img/Repair.png" alt="Repair Service Logo" width="60" class="mb-2">
                            <h3 class="mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Repair Service</h3>
                            <div class="text-muted">Staff Login</div>

                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger mt-3">Invalid username or password</div>
                            <?php endif; ?>
                        </div>

                        <form action="authentication/auth.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-block mt-3" style="background: rgb(53, 59, 72); color: #fff;">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html> 