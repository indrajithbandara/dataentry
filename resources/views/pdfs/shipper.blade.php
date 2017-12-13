@extends('layouts.pdf')

@section('content')
<div class="padding-50 font">
    <div>
        <div class="float-left"><strong>{{ $invoice[17] }}</strong></div>
        <div class="float-right"><strong>Shipper #  </strong><span>{{ $invoice[1] }}</span></div>
        <div class="clear-fix"></div>
    </div>

    <div>
        <div class="float-left">
            @for($i = 0; $i < count($invoice[18]); $i++)
                <span>{{ $invoice[18][$i] }}</span><br>
            @endfor
            <span>Ph: {{ $invoice[19] }}</span><br>
            <span>Em: {{ $invoice[20] }}</span><br>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="half-width float-left padding-5">Ship To:</div>
        <div class="half-width float-left padding-5">Bill To:</div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="float-left half-width padding-5 light-border">
            @for($i = 0; $i < count($invoice[3]); $i++)
                <span>{{ $invoice[3][$i] }}</span><br>
            @endfor
        </div>
        <div class="float-left half-width padding-5 light-border">
            @for($i = 0; $i < count($invoice[4]); $i++)
                <span>{{ $invoice[4][$i] }}</span><br>
            @endfor
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="light-border under-half padding-5 float-left set-height">
            <div class="inline half-width sm-text"><span>Customer Order #</span></div>
            <div class="inline half-width md-text"><span>{{ $invoice[6] }}</span></div>
            <div></div>
            <div class="inline half-width sm-text"><span>Order Complete<span></div>
            <div class="inline half-width md-text"><span>{{ $invoice[11] }}<span></div>
        </div>
        <div class="light-border qtr-width padding-5 float-left set-height">
            <div class="inline half-width sm-text"><span>Ship Date</span></div>
            <div class="inline half-width md-text"><span>{{ $invoice[2] }}</span></div>
            <div></div>
            <div class="text-center full-width sm-text"><span>HSCID 3910.00.00/8803.30<span></div>
        </div>
        <div class="light-border qtr-width padding-5 float-left set-height">
            <div class="inline half-width sm-text">Carrier</div>
            <div class="inline half-width md-text"><strong>{{ $invoice[12] }}</strong></div>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div class="full-width height-150">
        <table>
            <thead>
                <tr>
                    <th class="text-center padding-46-sides underline">Line Item</th>
                    <th class="text-center padding-46-sides underline">Part Number</th>
                    <th class="text-center padding-46-sides underline">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($invoice[7]); $i++)
                        <tr>
                        @foreach($invoice[7][$i] as $key => $value)
                                @if($key === 'qty' && $value != 0)
                                    <td class="text-center">{{ $value }}</td>
                                @elseif($key === 'product' && $value !== '')
                                    <td class="text-center">{{ $value }}</td>
                                @elseif($key === 'item' && $value != 0)
                                    <td class="text-center">{{ $value }}</td>
                                @endif                           
                        @endforeach
                        </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="more-space"></div>

    <div class="text-center full-width md-text padding-46-sides">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
    </div>

    <div class="space"></div>

    <div class="space"></div>

    <div class="text-center full-width sm-text padding-46-sides">
        CERTIFIED THAT QUALITY ASSURANCE DEPARTMENT HAS INSPECTED THE PARTS AND THEY ADHERE TO ALL APPLICABLE DRAWINGS AND/OR SPECIFICATIONS
    </div>

    <div class="space"></div>

    <div class="text-center full-width sm-text padding-46-sides">
        Please notify us immediately if an error is found in shipment.
    </div>

    <div class="space"></div>
    <div class="space"></div>

    <div class="float-left sm-text">
        <span>{{ $invoice[23] }}</span>
    </div>
    <div class="clear-fix"></div>

</div>
@endsection