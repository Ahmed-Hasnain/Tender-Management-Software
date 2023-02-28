<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ascent</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: "Arial Narrow", Arial, sans-serif !important;
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
        .w-77 {
            width: 77%;
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
                <tr style="border-bottom: 4px solid #894e3c !important;">
                    <td style="border: 0px !important; width: 45%;">
                        <img src="{{public_path($logo)}}" alt="Logo" height="100" width="150">
                        <p><strong style="text-align: left;">NTN # 5599160-8</strong></p>
                    </td>
                    <td style="border: 0px !important; width: 30%; vertical-align: middle; text-align: left; font-size: 20px">
                        Quotation
                    </td>
                    <td style="text-align: justify; width: 25%; margin-right: -80px !important; border: 0px !important">
                        <div style="border-left: 3px solid #323653 !important; padding-left: 8px !important">
                            <span style="color:#323653">Tel: +92 318 3788114</span><br>
                            <span style="color:#323653">Fax: +92 51 8772576</span><br>
                            <span style="color:#323653">Office # 18, 3<sup>rd</sup> Floor,</span><br> 
                            <span style="color:#323653">Gulberg Trade Center, Business Park,</span><br> 
                            <span style="color:#323653">Gulberg Greens, Islamabad</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="padding-top: 20px;">
            <tbody>
                <tr>
                    <td style="border: 0px !important;" class="w-50">
                        <table style="margin-top: 10px;"> 
                            <tbody>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-weight: bold;">
                                        Customer Information
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Name</strong></td>
                                    <td class="w-77">{{$quotation->tender->client->name}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Reference</strong></td>
                                    <td class="w-77">{{$quotation->tender->reference_no}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Date</strong></td>
                                    <td class="w-77">{{dateFormate($quotation->tender->rfq_date)}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Validity</strong></td>
                                    <td class="w-77">{{$quotation->validity_of_quotation}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="text-align: justify; border: 0px !important;" class="w-50">  
                        <table style="margin-top: 10px;"> 
                            <tbody>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-weight: bold;">
                                        Our Information
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>File Name</strong></td>
                                    <td class="w-77">{{$quotation->tender->file_name}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Reference</strong></td>
                                    <td class="w-77">{{$quotation->reference_no}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Date</strong></td>
                                    <td class="w-77">{{dateFormate($quotation->applied_date)}}</td>
                                </tr>
                                <tr>
                                    <td class="w-33"><strong>Delivery Time</strong></td>
                                    <td class="w-77">{{$quotation->delivery_time}}</td>
                                </tr>
                            </tbody>
                        </table>
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
                <th class="w-5">UOM</th>
                <th class="w-5">Qty</th>
                <th>Unit Price ({{$quotation->currency}})</th>
                <th>Total Amount ({{$quotation->currency}})</th>
            </tr>
        </thead>
        <tbody>
            @if ($quotation->items->count() > 0)  
                @foreach ($quotation->items as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td class="w-50">{{$item->tenderItem?->item?->name}}<br> <small> {{$item->tenderItem?->description}}</small></td>
                        <td class="w-5">{{$item->tenderItem?->unit?->short_name}}</td>
                        <td class="w-5">{{$item->tenderItem?->qty}}</td>
                        <td>{{numberFormate($item->unit_price)}}</td>
                        <td>{{numberFormate($item->total_price)}}</td>
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
        @foreach (breakString($quotation->terms_and_conditions) as $term)
            <p>{{$term}}</p>
        @endforeach
    </div>
</body>
</html>