<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayPal Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f7fafd;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .outer-card {
            max-width: 500px;
            margin: 0 auto;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            background: #fff;
            padding: 36px 24px 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .outer-title {
            color: #003087;
            font-weight: 700;
            font-size: 2.1rem;
            margin-bottom: 28px;
            text-align: center;
            letter-spacing: 1px;
        }
        .paypal-logo {
            width: 90px;
            height: 38px;
            object-fit: contain;
            margin-bottom: 18px;
        }
        .paypal-form-group {
            margin-bottom: 18px;
            width: 100%;
        }
        .paypal-label {
            color: #003087;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 6px;
            margin-left: 2px;
            letter-spacing: 1px;
        }
        .paypal-input {
            background: rgba(0,0,0,0.03);
            border: 1px solid #b0b0b0;
            border-radius: 10px;
            font-size: 1.1rem;
            padding: 10px 14px;
            color: #222;
            width: 100%;
            transition: box-shadow 0.2s, border 0.2s;
        }
        .paypal-input:focus {
            outline: none;
            border: 2px solid #003087;
            box-shadow: 0 4px 16px #00308733;
            background: #fff;
        }
        .btn-paypal {
            background: #003087;
            color: #fff;
            border-radius: 50px;
            font-size: 18px;
            padding: 10px 0;
            width: 100%;
            border: none;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 0 2px 12px #00308733;
            transition: background 0.2s, color 0.2s;
        }
        .btn-paypal:hover {
            background: #0070ba;
            color: #fff;
        }
        .btn-back {
            background: #eee;
            color: #003087;
            border-radius: 50px;
            font-size: 16px;
            padding: 8px 32px;
            border: none;
            font-weight: 600;
            margin-top: 12px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-back:hover {
            background: #003087;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="outer-card">
        <div class="outer-title">PayPal Payment</div>
        <img src="images/PayPal-Logo-History-1.png" alt="PayPal" class="paypal-logo">
        <form method="post" action="paypal_payment_process.php" autocomplete="off" style="width:100%; max-width:350px;">
            <div class="paypal-form-group">
                <label for="paypal_email" class="paypal-label">PayPal Email</label>
                <input type="email" class="paypal-input" id="paypal_email" name="paypal_email" placeholder="your@email.com" required>
            </div>
            <div class="paypal-form-group">
                <label for="paypal_amount" class="paypal-label">Amount</label>
                <input type="number" class="paypal-input" id="paypal_amount" name="paypal_amount" placeholder="Amount" min="1" required>
            </div>
            <button type="submit" class="btn btn-paypal">Pay with PayPal</button>
        </form>
        <a href="payment.php" class="btn btn-back mt-2">Back</a>
    </div>
</body>
</html>
