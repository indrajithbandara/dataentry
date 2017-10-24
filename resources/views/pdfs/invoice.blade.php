@extends('layouts.pdf')

@section('content')
<div class="padding-50 font">
    <div>
        <div class="float-left"><strong>K&amp;S Enterprises</strong></div>
        <div class="float-right"><strong>Invoice #</strong><span>    51303109</span></div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="float-left">
            <span>10515 Rancho Road</span><br>
            <span>Adelanto, CA 92301 USA</span><br>
            <span>(760) 246-4010 FAX (760) 246-4017</span><br>
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
        <div class="border float-left half-width padding-5">
            <span>Eaton Aeroquip LLC</span><br>
            <span>NAFSC - 6365</span><br>
            <span>This site pays from receipt</span><br>
            <br>
            <span>Do not send invoice</span><br>
            <span>Cleveland, OH 44181-8025</span><br>
            <span>Attn: Accounts Payable Dept</span>
        </div>
        <div class="border float-left half-width padding-5">
            <span>Eaton Aeroquip LLC</span><br>
            <span>Toccoa Plant</span><br>
            <span>90 Clary Connector</span><br>
            <br>
            <span>Eastanollee, GA. 30538</span><br>
            <br>
            <span>Attn:</span>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div>
        <div class="border qtr-width padding-5 float-left set-height">
            <div class="float-left half-width sm-text"><span>Customer Order #</span></div>
            <div class="float-right half-width md-text"><span>TCS1858</span></div>
            <div class="clear-fix"></div>
            <div class="text-center full-width sm-text"><span>Customer Release #<span></div>
        </div>
        <div class="border qtr-width padding-5 float-left">
            <div class="float-left half-width sm-text"><span>Ship Date</span></div>
            <div class="float-right half-width md-text"><span>10/23/2017</span></div>
            <div class="clear-fix"></div>
            <div class="text-center full-width sm-text"><span>HSCID 3910.00.00/8803.30<span></div>
        </div>
        <div class="border qtr-width padding-5 float-left set-height">
            <div class="text-center"><strong>UPS</strong></div>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="space"></div>

    <div class="full-width">
        <table class="full-width">
            <thead>
                <tr>
                    <th class="border">Quantity</th>
                    <th class="border">Part Number</th>
                    <th class="border">Price</th>
                    <th class="border">Extension</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>20</td>
                    <td>S504-450</td>
                    <td>$21.55</td>
                    <td>$431.00</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection