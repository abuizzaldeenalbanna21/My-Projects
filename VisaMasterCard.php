<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visa / MasterCard Payment</title>
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
            max-width: 700px;
            margin: 0 auto;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            background: #fff;
            padding: 32px 24px 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .outer-title {
            color: #00b8d9;
            font-weight: 700;
            font-size: 2.1rem;
            margin-bottom: 28px;
            text-align: center;
            letter-spacing: 1px;
        }
        .visa-card {
            max-width: 650px;
            width: 540px;
            height: 320px;
            margin: 0 auto 24px auto;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            background: linear-gradient(135deg, #00b8d9 60%, #fff 100%);
            padding: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .visa-logo {
            position: absolute;
            top: 18px;
            right: 28px;
            width: 64px;
            height: 32px;
            object-fit: contain;
            z-index: 2;
        }
        .visa-chip {
            width: 48px;
            height: 32px;
            background: linear-gradient(120deg, #e0e0e0 60%, #bdbdbd 100%);
            border-radius: 8px;
            margin-top: 28px;
            margin-left: 28px;
            margin-bottom: 18px;
        }
        .visa-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0 28px 18px 28px;
        }
        .visa-input-row {
            display: flex;
            gap: 16px;
            margin-bottom: 8px;
        }
        .visa-input,
        .visa-input-short {
            background: rgba(255,255,255,0.85);
            border: none;
            border-radius: 10px;
            font-size: 1.15rem;
            padding: 8px 12px;
            box-shadow: 0 2px 8px #00b8d91a;
            letter-spacing: 2px;
            color: #222;
            font-family: 'Courier New', Courier, monospace;
            transition: box-shadow 0.2s, border 0.2s;
        }
        .visa-input:focus,
        .visa-input-short:focus {
            outline: none;
            border: 2px solid #00b8d9;
            box-shadow: 0 4px 16px #00b8d955;
            background: #fff;
        }
        .visa-input {
            width: 100%;
            margin-bottom: 8px;
        }
        .visa-input-short {
            width: 100%;
        }
        .visa-label {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 2px;
            margin-left: 2px;
            letter-spacing: 1px;
        }
        .btn-pay {
            background: #fff;
            color: #00b8d9;
            border-radius: 50px;
            font-size: 18px;
            padding: 8px 0;
            width: 100%;
            border: none;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 0 2px 12px #00b8d955;
            transition: background 0.2s, color 0.2s;
        }
        .btn-pay:hover {
            background: #00b8d9;
            color: #fff;
        }
        .btn-back {
            background: #eee;
            color: #00b8d9;
            border-radius: 50px;
            font-size: 16px;
            padding: 8px 32px;
            border: none;
            font-weight: 600;
            margin-top: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-back:hover {
            background: #00b8d9;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="outer-card">
        <div class="outer-title">Visa / MasterCard</div>
        <div class="visa-card">
            <img src="images/c6a1fe7033dc3c76ec28d13c3c7699c2.jpg" alt="Visa" class="visa-logo">
            <div class="visa-chip"></div>
            <form method="post" action="visa_payment_process.php" autocomplete="off" class="visa-form">
                <label for="card_number" class="visa-label">Card Number</label>
                <input type="text" maxlength="19" class="visa-input" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                <div class="visa-input-row">
                    <div style="flex:1;">
                        <label for="expiry" class="visa-label">Expiry</label>
                        <input type="text" maxlength="5" class="visa-input-short" id="expiry" name="expiry" placeholder="MM/YY" required>
                    </div>
                    <div style="flex:1;">
                        <label for="cvv" class="visa-label">CVV</label>
                        <input type="password" maxlength="4" class="visa-input-short" id="cvv" name="cvv" placeholder="CVV" required>
                    </div>
                </div>
                <label for="card_name" class="visa-label">Cardholder Name</label>
                <input type="text" class="visa-input" id="card_name" name="card_name" placeholder="Name on Card" required>
            </form>
        </div>
        <button type="submit" class="btn btn-pay">Pay Now</button>
        <a href="payment.php" class="btn btn-back mt-2">Back</a>
    </div>
</body>
</html>
