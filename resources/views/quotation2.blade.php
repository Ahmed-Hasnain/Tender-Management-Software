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
            padding-bottom: 20px;
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
        .w-50 {
            width: 50%;
        }
        .w-5 {
            width: 5%;
        }
        .w-10 {
            width: 10%;
        }
        table thead tr th{
            border: 0px !important;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="assets/images/logo/logo.png" alt="Logo" height="100" width="100">
        <div class="title">Invoice</div>
        <table>
            <tbody>
                <tr>
                    <td style="border: 0px !important;">
                        Your Company Name<br>
                        123 Main St<br>
                        Anytown, USA 12345<br>
                        Tel: 555-555-1212<br>
                        Email: info@yourcompany.com
                    </td>
                    <td style="border: 0px !important; vertical-align: top; text-align: center;">
                        Quotation
                    </td>
                    <td style="text-align: right; border: 0px !important;">
                        Your Company Name<br>
                        123 Main St<br>
                        Anytown, USA 12345<br>
                        Tel: 555-555-1212<br>
                        Email: info@yourcompany.com
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th class="w-50">Description</th>
                <th class="w-5">Qty</th>
                <th class="w-5">A/U</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="w-50">Lorum ipsum <br> <small> ipsum dolor, sit amet consectetur adipisicing elit.</small></td>
                <td class="w-5">100</td>
                <td class="w-5">Kg</td>
                <td>10</td>
                <td>100</td>
            </tr>
            <tr>
                <td>1</td>
                <td class="w-50">Lorum ipsum</td>
                <td class="w-5">10</td>
                <td class="w-5">Kg</td>
                <td>10</td>
                <td>100</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">Subtotal:</td>
                <td>80</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">GST %</td>
                <td>20</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">GST Amount:</td>
                <td>100</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">Grand Total:</td>
                <td>100</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table style="margin-top: 30px;"> 
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold;">
                    Terms and Conditions
                </td>
            </tr>
            <tr>
                <td class="w-50">Mode of Payment</td>
                <td class="w-50">asdas</td>
            </tr>
            <tr>
                <td class="w-50">Rate Basis</td>
                <td class="w-50">xcvxc</td>
            </tr>
            <tr>
                <td class="w-50">Delivery Period</td>
                <td class="w-50">xcvxc</td>
            </tr>
        </tbody>
    </table>

</body>
</html>