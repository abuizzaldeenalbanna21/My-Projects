<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f7fafd;
            min-height: 100vh;
        }
        .payment-card {
            max-width: 500px;
            margin: 60px auto;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.09);
            background: #fff;
            padding: 36px 28px;
        }
        .payment-title {
            color: #00b8d9;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 24px;
            text-align: center;
        }
        .payment-method {
            border: 2px solid #eee;
            border-radius: 16px;
            padding: 18px 12px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: border 0.2s, box-shadow 0.2s;
            background: #fafbfc;
        }
        .payment-method.selected, .payment-method:hover {
            border: 2px solid #00b8d9;
            box-shadow: 0 2px 12px #00b8d922;
            background: #f0fcff;
        }
        .payment-method img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            margin-right: 18px;
        }
        .payment-label {
            font-size: 1.1rem;
            font-weight: 500;
            color: #222;
        }
        .btn-pay {
            background: #00b8d9;
            color: #fff;
            border-radius: 50px;
            font-size: 18px;
            padding: 10px 0;
            width: 100%;
            border: none;
            transition: background 0.2s;
        }
        .btn-pay:hover {
            background: #009bb3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const methods = document.querySelectorAll('.payment-method');
            methods.forEach(method => {
                method.addEventListener('click', function () {
                    methods.forEach(m => m.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('payment_type').value = this.getAttribute('data-method');
                });
            });
        });
    </script>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <!-- Payment Card -->
                    <div class="payment-card">
                        <div class="payment-title">Payment</div>
                        <form method="post" action="payment_process.php">
                            <input type="hidden" name="payment_type" id="payment_type" value="">
                            <div class="payment-method" data-method="visa" onclick="window.location.href='VisaMasterCard.php';">
                                <img src="images/c6a1fe7033dc3c76ec28d13c3c7699c2.jpg" alt="Visa">
                                <span class="payment-label">Visa / MasterCard</span>
                            </div>
                            <div class="payment-method" data-method="paypal" onclick="window.location.href='paypal.php';">
                                <img src="images/PayPal-Logo-History-1.png" alt="PayPal">
                                <span class="payment-label">PayPal</span>
                            </div>
                            <button type="submit" class="btn btn-pay mt-4">Proceed to Payment</button>
                        </form>
                    </div>
                    <!-- End of Payment Card -->
                </div>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="text-center my-auto">
                            <span>Copyright &copy; Developer By Ali Albanna 2025</span>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>
