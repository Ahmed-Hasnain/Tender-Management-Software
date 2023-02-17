<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .header {
            text-align: left;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .address {
            margin-bottom: 20px;
        }
        .footer {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="assets/images/logo/logo.png" alt="Logo" height="80" width="80">
        <div class="title">Invoice</div>
        <div class="address">
            Your Company Name<br>
            123 Main St<br>
            Anytown, USA 12345<br>
            Tel: 555-555-1212<br>
            Email: info@yourcompany.com
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Grinder</td>
                <td>Lorum ipsum</td>
                <td>10</td>
                <td>10</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Grinder</td>
                <td>Lorum ipsum</td>
                <td>10</td>
                <td>10</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Grinder</td>
                <td>Lorum ipsum</td>
                <td>10</td>
                <td>10</td>
                <td>2</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="footer">Subtotal:</td>
                <td>80</td>
            </tr>
            <tr>
                <td colspan="4" class="footer">Tax:</td>
                <td>20</td>
            </tr>
            <tr>
                <td colspan="4" class="footer">Total:</td>
                <td>100</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>