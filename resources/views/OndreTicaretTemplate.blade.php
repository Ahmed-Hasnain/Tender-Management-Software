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
            padding-top: 120px !important;
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
        .page-break {
            page-break-after: always;
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
        .text-left {
            text-align: left !important;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        @page { margin: 85px 50px; }
        header { 
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            text-align: left;
            padding-bottom: 20px;
        }
        footer { 
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            border-top: 2px solid #5598cc !important;
        }
        .p-0 { padding: 0px; }
        .p-1 { padding: 1px; }
        .p-2 { padding: 2px; }
        .p-3 { padding: 3px; }
        .p-4 { padding: 4px; }
        .p-5 { padding: 5px; }
        .p-10 { padding: 10px; }
        .p-15 { padding: 15px; }
        .p-20 { padding: 20px; }
        .p-25 { padding: 25px; }
        .p-30 { padding: 30px; }
        .p-40 { padding: 40px; }
        .p-50 { padding: 50px; }
        
        .px-0 { padding-left: 0px; padding-right: 0px; }
        .px-1 { padding-left: 1px; padding-right: 1px; }
        .px-2 { padding-left: 2px; padding-right: 2px; }
        .px-3 { padding-left: 3px; padding-right: 3px; }
        .px-4 { padding-left: 4px; padding-right: 4px; }
        .px-5 { padding-left: 5px; padding-right: 5px; }
        .px-10 { padding-left: 10px; padding-right: 10px; }
        .px-15 { padding-left: 15px; padding-right: 15px; }
        .px-20 { padding-left: 20px; padding-right: 20px; }
        .px-25 { padding-left: 25px; padding-right: 25px; }
        .px-30 { padding-left: 30px; padding-right: 30px; }
        .px-40 { padding-left: 40px; padding-right: 40px; }
        .px-50 { padding-left: 50px; padding-right: 50px; }
        
        .py-0 { padding-top: 0px; padding-bottom: 0px; }
        .py-1 { padding-top: 1px; padding-bottom: 1px; }
        .py-2 { padding-top: 2px; padding-bottom: 2px; }
        .py-3 { padding-top: 3px; padding-bottom: 3px; }
        .py-4 { padding-top: 4px; padding-bottom: 4px; }
        .py-5 { padding-top: 5px; padding-bottom: 5px; }
        .py-10 { padding-top: 10px; padding-bottom: 10px; }
        .py-15 { padding-top: 15px; padding-bottom: 15px; }
        .py-20 { padding-top: 20px; padding-bottom: 20px; }
        .py-25 { padding-top: 25px; padding-bottom: 25px; }
        .py-30 { padding-top: 30px; padding-bottom: 30px; }
        .py-40 { padding-top: 40px; padding-bottom: 40px; }
        .py-50 { padding-top: 50px; padding-bottom: 50px; }
        
        .pt-0 { padding-top: 0px; }
        .pt-1 { padding-top: 1px; }
        .pt-2 { padding-top: 2px; }
        .pt-3 { padding-top: 3px; }
        .pt-4 { padding-top: 4px; }
        .pt-5 { padding-top: 5px; }
        .pt-10 { padding-top: 10px; }
        .pt-15 { padding-top: 15px; }
        .pt-20 { padding-top: 20px; }
        .pt-25 { padding-top: 25px; }
        
        .m-0 { margin: 0px; }
        .m-1 { margin: 1px; }
        .m-2 { margin: 2px; }
        .m-3 { margin: 3px; }
        .m-4 { margin: 4px; }
        .m-5 { margin: 5px; }
        .m-10 { margin: 10px; }
        .m-15 { margin: 15px; }
        .m-20 { margin: 20px; }
        .m-25 { margin: 25px; }
        .m-30 { margin: 30px; }
        .m-40 { margin: 40px; }
        .m-50 { margin: 50px; }
        
        .mx-0 { margin-left: 0px; margin-right: 0px; }
        .mx-1 { margin-left: 1px; margin-right: 1px; }
        .mx-2 { margin-left: 2px; margin-right: 2px; }
        .mx-3 { margin-left: 3px; margin-right: 3px; }
        .mx-4 { margin-left: 4px; margin-right: 4px; }
        .mx-5 { margin-left: 5px; margin-right: 5px; }
        .mx-10 { margin-left: 10px; margin-right: 10px; }
        .mx-15 { margin-left: 15px; margin-right: 15px; }
        .mx-20 { margin-left: 20px; margin-right: 20px; }
        .mx-25 { margin-left: 25px; margin-right: 25px; }
        .mx-30 { margin-left: 30px; margin-right: 30px; }
        .mx-40 { margin-left: 40px; margin-right: 40px; }
        .mx-50 { margin-left: 50px; margin-right: 50px; }
        
        .my-0 { margin-top: 0px; margin-bottom: 0px; }
        .my-1 { margin-top: 1px; margin-bottom: 1px; }
        .my-2 { margin-top: 2px; margin-bottom: 2px; }
        .my-3 { margin-top: 3px; margin-bottom: 3px; }
        .my-4 { margin-top: 4px; margin-bottom: 4px; }
        .my-5 { margin-top: 5px; margin-bottom: 5px; }
        .my-10 { margin-top: 10px; margin-bottom: 10px; }
        .my-15 { margin-top: 15px; margin-bottom: 15px; }
        .my-20 { margin-top: 20px; margin-bottom: 20px; }
        .my-25 { margin-top: 25px; margin-bottom: 25px; }
        .my-30 { margin-top: 30px; margin-bottom: 30px; }
        .my-40 { margin-top: 40px; margin-bottom: 40px; }
        .my-50 { margin-top: 50px; margin-bottom: 50px; }
        
        .mt-0 { margin-top: 0px; }
        .mt-1 { margin-top: 1px; }
        .mt-2 { margin-top: 2px; }
        .mt-3 { margin-top: 3px; }
        .mt-4 { margin-top: 4px; }
        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .mt-20 { margin-top: 20px; }

        .text-primary { color: #007bff; }
        .text-secondary { color: #f3f3f3; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
        .text-info { color: #17a2b8; }
        .text-light { color: #f8f9fa; }
        .text-dark { color: #343a40; }
        
        .bg-primary { background-color: #007bff; }
        .bg-secondary { background-color: #f3f3f3; }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; }
        .bg-info { background-color: #17a2b8; }
        .bg-light { background-color: #f8f9fa; }
        .bg-dark { background-color: #343a40; }
    </style>
</head>
<body>
    <header>
        <table>
            <tbody>
                <tr>
                    <td style="border: 0px !important; width: 75%;">
                        <img src="{{public_path($logo)}}" alt="Logo" height="100" width="520"><br><br>
                    </td>
                    <td style=" border: 0px !important; width: 35%;">
                        {{-- <span style="color:#5598cc">Office No. 1102, 11<sup>th</sup> Floor,</span><br>
                        <span style="color:#5598cc">Green Tower Trust, Jinnah</span><br>
                        <span style="color:#5598cc">Avenue, Blue Area,</span><br> 
                        <span style="color:#5598cc">Islamabad, Pakistan</span><br> --}}
                        <span style="color:#c9cc77">Tel: +92 51 2813153</span><br>
                        <span style="color:#c9cc77">Fax: +92 51 8444066</span><br><br>
                    </td>
                </tr>
                <tr style="border-bottom: 2px solid #5598cc !important;">
                    <td style="border: 0px !important; width: 75%;">
                        <span>NTN: 7354447-7</span><br>
                    </td>
                    <td style=" border: 0px !important; width: 35%;">
                        <span>STRN: 3277876132361</span> 
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    <footer>
        <p style="padding: 0px !important; margin: 0px !important; text-align: justified !important;">Head Quarter: Office No. 1102, 11<sup>th</sup> Floor, Green Tower Trust, Jinnah Avenue, Blue Area, Islamabad, Pakistan.</p>
    </footer>
    <main>
        <table>
            <tbody>
                <tr>
                    <td style="border: 0px !important;" class="w-33">
                        <strong>Our Reference:</strong> {{$quotation->reference_no}}<br>
                        <strong>Dated:</strong> {{dateFormate($date)}}<br>
                        <strong>Validity:</strong> {{addDaysToDate($quotation->applied_date, $quotation->validity_of_quotation)}}
                    </td>
                    <td style="border: 0px !important; vertical-align: top; text-align: center;" class="w-33">
                        QUOTATION
                    </td>
                    <td style="text-align: justify; border: 0px !important;" class="w-33">  
                        <strong>Customer Ref:</strong> {{$quotation->tender->reference_no}}<br>
                        <strong>RFQ Date:</strong> {{dateFormate($quotation->tender->rfq_date)}}<br>
                        <strong>Delivery Period:</strong> {{$quotation->delivery_time}} Days
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table>
            <thead>
                <tr>
                    <th class="w-5 text-center">Sr.</th>
                    <th class="w-50 text-center">Description</th>
                    <th class="w-5 text-center">UOM</th>
                    <th class="w-5 text-center">Qty</th>
                    <th class="text-center">Unit Price ({{$quotation->currency}})</th>
                    <th class="text-center">Total Amount ({{$quotation->currency}})</th>
                </tr>
            </thead>
            <tbody>
                @if ($quotation->items->count() > 0)  
                    @foreach ($quotation->items as $key => $item)
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            <td class="w-50 ">{{$item->tenderItem?->item?->name}}<br> <small> {{$item->tenderItem?->description}}</small></td>
                            <td class="w-5 text-center">{{$item->tenderItem?->unit?->short_name}}</td>
                            <td class="w-5 text-center">{{$item->tenderItem?->qty}}</td>
                            <td class="text-right">{{numberFormate($item->unit_price)}}</td>
                            <td class="text-right">{{numberFormate($item->total_price)}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">Subtotal:</td>
                    <td class="text-right">{{numberFormate($quotation->total_price)}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">GST({{$quotation->tax}}%):</td>
                    <td class="text-right">{{numberFormate(calculateTax($quotation->tax, $quotation->total_price))}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">Grand Total:</td>
                    <td class="text-right">{{numberFormate($quotation->total_price + calculateTax($quotation->tax, $quotation->total_price))}}</td>
                </tr>
            </tfoot>
        </table>
        <br>
        <div>   
            <p class="text-center pt-20"><strong>Yours Truly</strong></p> 
        </div>
        <br>
        <div>
            <h3 style="text-decoration: underline;">Terms and Conditions:</h3>
            <p><strong>Mode of Payment:</strong>  {{$quotation->tender->mop->name}}</p> 
            <p><strong>Rate Basis:</strong>  {{$quotation->tender->rate_basis}}</p> 
        </div>
    </main>
</body>
</html>