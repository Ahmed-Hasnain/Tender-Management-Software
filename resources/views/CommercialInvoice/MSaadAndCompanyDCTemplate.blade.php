<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Commercial Invoice</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: "Courier New", Courier, monospace !important;
            font-size: 14px;
            padding-top: 60px !important;
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
            top: -70px;
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
            border-top: 2px solid #bd483b !important;
        }
        .pagenum:before {
            content: counter(page);
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
                    <td style="border: 0px !important; width: 72%;">
                        <img src="{{public_path($logo)}}" alt="Logo" height="100" width="200"><br>
                        NTN: 7881680-2<br>
                    </td>
                    <td style="width: 28%; border: 0px !important">
                        <div>
                            <span style="color:#323653">Tel: +92 51 2745668</span><br>
                            <span style="color:#323653">Fax: +92 51 2745778</span><br>
                            <span style="color:#323653">Email: msaadandcom@gmail.com</span><br><br>
                            STRN: 3277876141811<br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    <footer>
        <p style="padding: 0px !important; margin: 0px !important; text-align: justified !important;">Head Quarter: Office # 18, 3<sup>rd</sup> Floor, Gulberg Trade Center, Business Park, Gulberg Greens, Islamabad.</p>
    </footer>
    <main>
    <p class="text-center" style="padding: 0px; font-weight:bold; text-transform: uppercase; font-size: 16px;">Sale Tax Invoice</p>
        <table style="padding-top: 0px;line-height:10px;">
            <tbody>
                <tr>
                    <td style="border: 0px !important; width: 60% !important;" class=" text-right">  
                        <table style="margin-top: 10px;"> 
                            <tbody>
                                <tr>
                                    <td class="w-30" style="border: 0px !important; color: gray !important;"><strong>Date:</strong></td>
                                    <td class="w-70" style="border: 0px !important; border-left: 1px solid gray !important;">{{currentDate()}}</td>
                                </tr>
                                <tr>
                                    <td class="w-30" style="border: 0px !important; color: gray !important;"><strong>No #</strong></td>
                                    <td class="w-70" style="border: 0px !important; border-left: 1px solid gray !important;">C-Invc # {{$supplyOrder->id}}</td>
                                </tr>
                                <tr>
                                    <td class="w-30" style="border: 0px !important; color: gray !important;"><strong>Reference:</strong></td>
                                    <td class="w-70" style="border: 0px !important; border-left: 1px solid gray !important;">{{ $supplyOrder->quotation?->reference_no }} - Dated: {{dateFormate($supplyOrder?->quotation?->applied_date)}}</td>
                                </tr>
                                <tr>
                                    <td class="w-30" style="border: 0px !important; color: gray !important;"><strong>Cust.Name:</strong></td>
                                    <td class="w-70" style="border: 0px !important; border-left: 1px solid gray !important;">{{$supplyOrder?->quotation?->tender?->client?->name}}</td>
                                </tr>
                                <tr>
                                    <td class="w-30" style="border: 0px !important; color: gray !important;"><strong>Customer Ref:</strong></td>
                                    <td class="w-70" style="border: 0px !important; border-left: 1px solid gray !important;">{{$supplyOrder?->quotation?->tender?->reference_no}} - Dated: {{dateFormate($supplyOrder?->quotation?->tender?->rfq_date)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th class="w-5 text-center">Sr.</th>
                    <th class="w-50 text-center">Description</th>
                    <th class="w-5 text-center">Qty</th>
                    <th class="w-5 text-center">A/U</th>
                    <th class="w-10 text-center">Unit Price</th>
                    <th class="w-10 text-center">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($supplyOrder->items->count() > 0)  
                    @foreach ($supplyOrder->items as $key => $item)
                        <tr>
                            <td  class="text-center">{{$key+1}}</td>
                            <td class="w-50">{{$item->quotationItem?->tenderItem?->item?->name}}<br><small> {{$item->quotationItem?->tenderItem?->description}}</small></td>
                            <td class="w-5 text-center">{{$item->qty}}</td>
                            <td class="w-5 text-center">{{$item->quotationItem?->tenderItem?->unit?->short_name}}</td>
                            <td class="text-right">{{numberFormate($item->unit_price)}}</td>
                            <td class="text-right">{{numberFormate($item->total)}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">Subtotal:</td>
                    <td class="text-right">{{numberFormate($supplyOrder->total_price)}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">GST({{$supplyOrder?->quotation?->tax}}%):</td>
                    <td class="text-right">{{numberFormate(calculateTax($supplyOrder?->quotation?->tax, $supplyOrder->total_price))}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="footer" style="border: 0px !important;">Grand Total ({{$supplyOrder->quotation?->currency}}):</td>
                    <td class="text-right">{{numberFormate($supplyOrder->total_price + calculateTax($supplyOrder?->quotation?->tax, $supplyOrder->total_price))}}</td>
                </tr>
            </tfoot>
        </table>
        <br>
        <br>
        <strong>Store Delivered: </strong>
        <br>
        <ol>
            @foreach ($supplyOrder->deliveryChallan as $key => $dc)
                <li>
                    <strong>Reference #: </strong> {{$dc->reference_no}} <strong>Dated:</strong> {{dateFormate($dc->created_at)}}
                </li>
                <br>
            @endforeach
        </ol>
        <br>
        <br>
        <br>
        <div>
            <p class="text-right pt-20"><strong>Yours Truly</strong></p> 
        </div>
    </main>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT} (Ref # {{$supplyOrder->quotation?->reference_no}})";
            $size = 8;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = 37;
            // Move the page number to the top of the page (adjust the Y-coordinate)
            $y = 10; // Change this value to position the page number
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>