<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ondre Ticaret</title>
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
        .w-20 {
            width: 20%;
        }
        .w-33 {
            width: 33%;
        }
        table thead tr th{
            border: 0px !important;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tbody>
                <tr>
                    <td style="border: 0px !important; width: 75%;">
                        <img src="{{public_path($logo)}}" alt="Logo" height="100" width="520">
                    </td>
                    <td style="text-align: justify; border: 0px !important; width: 35%;">
                        <span style="color:#5598cc">Office No. 1102, 11<sup>th</sup> Floor,</span><br>
                        <span style="color:#5598cc">Green Tower Trust, Jinnah</span><br>
                        <span style="color:#5598cc">Avenue, Blue Area,</span><br> 
                        <span style="color:#5598cc">Islamabad, Pakistan</span><br>
                        <span style="color:#c9cc77">Tel: +92 51 2813153</span><br>
                        <span style="color:#c9cc77">Fax: +92 51 2813154</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="padding-top: 20px;">
            <tbody>
                <tr>
                    <td style="background: white; border: 0px;" colspan="2">
                        <span style="font-weight: bold;">Subject: Quotation Against Your Inquiry</span>
                    </td>
                </tr>
                <tr>
                    <td style="border: 0px !important;" class="w-33">
                        Our Reference: {{$quotation->reference_no}}<br>
                        Dated: {{dateFormate($quotation->applied_date)}}<br>
                        Validity: {{$quotation->validity_of_quotation}}
                    </td>
                    <td style="border: 0px !important; vertical-align: top; text-align: center;" class="w-33" >
                        Quotation
                    </td>
                    <td style="text-align: justify; border: 0px !important;" class="w-33">  
                        Customer Reference: {{$quotation->tender->reference_no}}<br>
                        RFQ Date: {{dateFormate($quotation->tender->rfq_date)}}<br>
                        Delivery Period: {{$quotation->delivery_time}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th class="w-5">Sr.</th>
                <th class="w-50">Description</th>
                <th class="w-5">Qty</th>
                <th class="w-5">A/U</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @if ($quotation->items->count() > 0)  
                @foreach ($quotation->items as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td class="w-50">{{$item->tenderItem?->item?->name}}<br> <small> {{$item->tenderItem?->description}}</small></td>
                        <td class="w-5">{{$item->tenderItem?->qty}}</td>
                        <td class="w-5">{{$item->tenderItem?->unit?->short_name}}</td>
                        <td>{{$quotation->currency}} {{numberFormate($item->unit_price)}}</td>
                        <td>{{$quotation->currency}}  {{numberFormate($item->total_price)}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">Subtotal:</td>
                <td>{{$quotation->currency}} {{numberFormate($quotation->total_price)}}</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">GST %</td>
                <td>{{$quotation->tax}}</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">GST Amount:</td>
                <td>{{$quotation->currency}} {{numberFormate(calculateTax($quotation->tax, $quotation->total_price))}}</td>
            </tr>
            <tr>
                <td colspan="5" class="footer" style="border: 0px !important;">Grand Total:</td>
                <td>{{$quotation->currency}} {{numberFormate($quotation->total_price + calculateTax($quotation->tax, $quotation->total_price))}}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <div>
        <h3 style="text-decoration: underline;">Terms and Conditions:</h3>
        <p><strong>Mode of Payment:</strong>  {{$quotation->tender->mop->name}}</p> 
        <p><strong>Rate Basis:</strong>  {{$quotation->tender->rate_basis}}</p> 
    </div>
</body>
</html>