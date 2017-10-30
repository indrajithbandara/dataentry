@extends('layouts.pdf')

@section('content')
<div class="padding-50 font">
    <div>
        <div class="float-left"><strong>{{ $invoice[15] }}</strong></div>
        <div class="float-right"><strong>Invoice #  </strong><span>{{ $invoice[1] }}</span></div>
        <div class="clear-fix"></div>
    </div>

    <div>
        <div class="float-left">
            @for($i = 0; $i < count($invoice[16]); $i++)
                <span>{{ $invoice[16][$i] }}</span><br>
            @endfor
            <span>Ph: {{ $invoice[17] }}</span><br>
            <span>Em: {{ $invoice[18] }}</span><br>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="half-width float-left padding-5">Bill To:</div>
        <div class="half-width float-left padding-5">Ship To:</div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="float-left half-width padding-5 light-border">
            @for($i = 0; $i < count($invoice[4]); $i++)
                <span>{{ $invoice[4][$i] }}</span><br>
            @endfor
        </div>
        <div class="float-left half-width padding-5 light-border">
            @for($i = 0; $i < count($invoice[3]); $i++)
                <span>{{ $invoice[3][$i] }}</span><br>
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
            <div class="inline half-width sm-text"><span>Customer Release #<span></div>
            <div class="inline half-width md-text"><span>45<span></div>
        </div>
        <div class="light-border qtr-width padding-5 float-left set-height">
            <div class="inline half-width sm-text"><span>Ship Date</span></div>
            <div class="inline half-width md-text"><span>{{ $invoice[2] }}</span></div>
            <div></div>
            <div class="text-center full-width sm-text"><span>HSCID 3910.00.00/8803.30<span></div>
        </div>
        <div class="light-border qtr-width padding-5 float-left set-height">
            <div class="inline half-width sm-text">Carrier</div>
            <div class="inline half-width md-text"><strong>UPS</strong></div>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div class="full-width max-150">
        <table>
            <thead>
                <tr>
                    <th class="text-center padding-20-sides underline">Part Number</th>
                    <th class="text-center padding-46-sides underline">Quantity</th>
                    <th class="text-center padding-46-sides underline">Price</th>
                    <th class="text-center padding-46-sides underline">Extension</th>
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
                                @elseif($key === 'unit' && $value != 0)
                                    <td class="text-center">${{ $value }}</td>
                                @elseif($key === 'extended' && $value != 0)
                                    <td class="text-center">${{ $value }}</td>
                                @endif                           
                        @endforeach
                        </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="more-space"></div>

    <div class="float-right border padding-15">
        <div class="full-width margin-bottom-20">
            <div class="inline qtr-width">
                <span>Sub Total</span>
            </div>
            <div class="inline small-width text-right">
                <span>${{ $invoice[13] }}</span>
            </div>
        </div>
        <div class="full-width margin-bottom-20">
            <div class="inline qtr-width">
                <span>Shipping Charges</span>
            </div>
            <div class="inline small-width text-right">
                <span>${{ $invoice[8] }}</span>
            </div>
        </div>
        <div class="full-width margin-bottom-20">
            <div class="inline qtr-width">
                <span>Misc. Charges</span>
            </div>
            <div class="inline small-width text-right">
                <span>$0.00</span>
            </div>
        </div>
        <div class="full-width">
            <div class="inline qtr-width">
                <span>Invoice Total</span>
            </div>
            <div class="inline small-width text-right">
                <span>${{ $invoice[9] }}</span>
            </div>
        </div>
    </div>
    <div class="clear-fix"></div>

    <div class="space"></div>

    <div class="float-left sm-text">
        <span>{{ $invoice[20] }}</span>
    </div>
    <div class="clear-fix"></div>

</div>
@endsection