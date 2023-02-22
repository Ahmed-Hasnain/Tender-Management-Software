<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: "Courier New", Courier, monospace !important;
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
        <table>
            <tbody>
                <tr>
                    <td style="border: 0px !important; width: 72%;">
                        <img src="{{public_path($logo)}}" alt="Logo" height="100" width="200">
                    </td>
                    <td style="width: 28%; border: 0px !important">
                        <div>
                            <span style="color:#323653">Tel: +92 51 2745668</span><br>
                            <span style="color:#323653">Fax: +92 51 2745778</span><br>
                            <span style="color:#323653">Email: msaadandcom@gmail.com</span><br>
                            <span style="color:#323653">Office # 18, 3<sup>rd</sup> Floor,</span><br> 
                            <span style="color:#323653">Gulberg Trade Center,</span><br> 
                            <span style="color:#323653">Business Park,</span><br> 
                            <span style="color:#323653">Gulberg Greens, Islamabad</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- <img src="{{public_path($logo)}}" alt="Logo" height="100" width="200"> --}}
        <table style="padding-top: 20px;">
            <tbody>
                <tr>
                    <td style="border: 0px !important;">
                        NTN: 7881680-2<br><br>
                        <strong>Our Reference:</strong> {{$quotation->reference_no}}<br>
                        <strong>Customer Reference:</strong> {{$quotation->tender->reference_no}}<br>
                        <strong>File Name:</strong> {{$quotation->tender->file_name}}
                    </td>
                    <td style="border: 0px !important; vertical-align: top; text-align: center;">
                        Quotation<br>
                    </td>
                    <td style="text-align: right; border: 0px !important;">
                        STRN: 3277876141811<br><br>
                        <strong>Dated:</strong> {{dateFormate($quotation->applied_date)}}<br>
                        <strong>Dated:</strong> {{dateFormate($quotation->tender->rfq_date)}}<br>
                        <strong>Validity:</strong> {{$quotation->validity_of_quotation}}
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
    <table style="margin-top: 30px;"> 
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold;">
                    Terms and Conditions
                </td>
            </tr>
            <tr>
                <td class="w-50">Mode of Payment</td>
                <td class="w-50">{{$quotation->tender->mop->name}}</td>
            </tr>
            <tr>
                <td class="w-50">Rate Basis</td>
                <td class="w-50">{{$quotation->tender->rate_basis}}</td>
            </tr>
            <tr>
                <td class="w-50">Delivery Period</td>
                <td class="w-50">{{$quotation->delivery_time}}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>