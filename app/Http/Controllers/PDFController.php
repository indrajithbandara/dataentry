<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Vsmoraes\Pdf\Pdf;

class PDFController extends Controller
{
    /**
    * @var PDF Object
    */
    private $pdf;

    /**
    * Set pdf variable
    * 
    * @param $pdf  PDF Object
    * @return void
    */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
    * PDF INVOICES
    *
    * @param $id of the invoice
    * @return pdf
    */
    public function invoice($id)
    {
        // Get Invoice Data by id
        $invoice = Invoice::find($id);
        // Get Company Data
        if(Company::find(1)){
            $company = Company::find(1);
        }else{
            return redirect('/invoices')->with('company-message', 'Invoice can not be printed with out company information. Please go to your settings to add your companies information.');
        }
        /*
        * The data coming from the invoice's tables needs some processing in order for it to be more accessable on the
        * pdf templates. Though php computation is possible on blade templates, this method functions to take the logic
        * away from the template and process it here. $newInvoice is an array that all the processed data well be pushed
        * to in order to send with the view.
        */
        $newInvoice = [];
        /*
        * $invoice['original'] holds all the data for the invoice model. This object is looped over so that certain values
        * can be processed before being pushed to the $newInvoice array.
        */
        foreach($invoice['original'] as $key => $value){
            /*
            * The 'customers' and 'line_items' are returned as a double encoded string. These properties on the model have been given
            * a casting of 'object' which results in a double encoded string. This if statement checks for the 'customers' and 'line_items'
            * strings, double decodes them and places them in a variable called $d_decoded. The parameter 'true' is chosen so that the 
            * results of the decoding would return an object.
            */
            if($key === 'customer' || $key === 'line_items'){
                $d_decoded = $this->doubleDecode($value);
                /*
                * Both the 'customers' and 'line_items' are looped over but the one that matters most is the 'shipto' and 'billto' keys.
                * This is so they can be converted to an array by exploding the string evertime the '#' symbol is detected. This is 
                * explained on the 'customers.vue' file. In short, '#' is a special character that allows the user to decide when they
                * want a line break when composin the address for their customers. This allows for more customization as the address
                * information needs to be procises for packaging and mailing. 
                */
                foreach($d_decoded as $k => $v){
                    if($k === 'shipto' || $k === 'billto'){
                        $addressArr = explode("\n", $v);
                        array_push($newInvoice, $addressArr);
                    }
                }
                array_push($newInvoice, $d_decoded);
            /*
            * Next, the 'date' key is isolated so that the data format back be changed from year-month-day to day-month-year.
            * the string is is the concatinated and pushed to the 'newInvoice' array.
            */
            } else if ($key === 'date'){
                $dateArr = explode('-', $value);
                $newDate = $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[0];
                array_push($newInvoice, $newDate);
            // All other values need no further processing, they are pushed to the 'newInvoice' array.
            } else {
                array_push($newInvoice, $value);
            }
        }
        /*
        * A 'sub total' value is needed for the invoice information. The total property includes the shipping already.
        * This math is handled on the frontend of the invoice section. Here, we create a new array value to passed on to the pdf
        * template. 
        */
        $sub_total = floatval($invoice['original']['total']) - ( floatval($invoice['original']['ship_fee'] + floatval($invoice['original']['misc_char']) ) );
        array_push($newInvoice, $sub_total);
        /*
        * lastly, we need to add the company information to place onto the pdf document. 
        */
        foreach($company['original'] as $key => $value){
            if($key === 'address'){
                $addArr = explode("\n", $value);
                array_push($newInvoice, $addArr);
            }else if($key === 'inv_prefix'){
                //
            }else{
                array_push($newInvoice, $value);
            }
        }   
        /*
        * Finally, the view and the newInvoice data is stored in a variable to be passed to the PDF objects instance for pdf
        * generation. 
        */
        $html = view('pdfs.invoice')->with('invoice', $newInvoice);
        return $this->pdf
            ->load($html)
            ->show();
    }


    /**
    * PDF SHIPPER
    *
    * @param $id of the invoice
    * @return pdf
    */
    public function shipper($id)
    {
        // Get Invoice Data by id
        $invoice = Invoice::find($id);
        // Get Company Data
        if(Company::find(1)){
            $company = Company::find(1);
        }else{
            return redirect('/invoices')->with('company-message', 'Shipper can not be printed with out company information. Please go to your settings to add your companies information.');
        }
        /*
        * The data coming from the invoice's tables needs some processing in order for it to be more accessable on the
        * pdf templates. Though php computation is possible on blade templates, this method functions to take the logic
        * away from the template and process it here. $newInvoice is an array that all the processed data well be pushed
        * to in order to send with the view.
        */
        $newInvoice = [];
        /*
        * $invoice['original'] holds all the data for the invoice model. This object is looped over so that certain values
        * can be processed before being pushed to the $newInvoice array.
        */
        foreach($invoice['original'] as $key => $value){
            /*
            * The 'customers' and 'line_items' are returned as a double encoded string. These properties on the model have been given
            * a casting of 'object' which results in a double encoded string. This if statement checks for the 'customers' and 'line_items'
            * strings, double decodes them and places them in a variable called $d_decoded. The parameter 'true' is chosen so that the 
            * results of the decoding would return an object.
            */
            if($key === 'customer' || $key === 'line_items'){
                $d_decoded = $this->doubleDecode($value);
                /*
                * Both the 'customers' and 'line_items' are looped over but the one that matters most is the 'shipto' and 'billto' keys.
                * This is so they can be converted to an array by exploding the string evertime the '#' symbol is detected. This is 
                * explained on the 'customers.vue' file. In short, '#' is a special character that allows the user to decide when they
                * want a line break when composin the address for their customers. This allows for more customization as the address
                * information needs to be procises for packaging and mailing. 
                */
                foreach($d_decoded as $k => $v){
                    if($k === 'shipto' || $k === 'billto'){
                        $addressArr = explode("\n", $v);
                        array_push($newInvoice, $addressArr);
                    }
                }
                array_push($newInvoice, $d_decoded);
            /*
            * Next, the 'date' key is isolated so that the data format back be changed from year-month-day to day-month-year.
            * the string is is the concatinated and pushed to the 'newInvoice' array.
            */
            } else if ($key === 'date'){
                $dateArr = explode('-', $value);
                $newDate = $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[0];
                array_push($newInvoice, $newDate);
            // All other values need no further processing, they are pushed to the 'newInvoice' array.
            } else {
                array_push($newInvoice, $value);
            }
        }
        /*
        * lastly, we need to add the company information to place onto the pdf document. 
        */
        foreach($company['original'] as $key => $value){
            if($key === 'address'){
                $addArr = explode("\n", $value);
                array_push($newInvoice, $addArr);
            }else if($key === 'inv_prefix'){
                //
            }else{
                array_push($newInvoice, $value);
            }
        }
        /*
        * Finally, the view and the newInvoice data is stored in a variable to be passed to the PDF objects instance for pdf
        * generation. 
        */
        $html = view('pdfs.shipper')->with('invoice', $newInvoice);
        return $this->pdf
            ->load($html)
            ->show();
    }

    /**
    *
    * @param $start  Start date of the report
    * @param $end  End date of the report
    * @return pdf
    */
    public function invoiceReport($start, $end) 
    {
        $report = DB::table('invoices')
                    ->select('inv_num', 'date', 'customer', 'total')
                    ->whereBetween('date', [$start, $end])
                    ->get()
                    ->toArray();
        $newReport = [];
        for($i = 0; $i < count($report); $i++){
            $inner = [];
            foreach($report[$i] as $k => $v){
                if($k === 'customer'){
                    $newVal = $this->doubleDecode($v);
                    $array = $this->doubleDecode($newVal);
                    array_push($inner, $array['name']);
                } else if ($k === 'date'){
                    $dateArr = explode('-', $v);
                    $newDate = $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[0];
                    array_push($inner, $newDate);
                }else{
                    array_push($inner, $v);
                }
            }
            array_push($newReport, $inner);
        }

        $total = 0;
        for($i = 0; $i < count($newReport); $i++){
            $total += $newReport[$i][3];
        }
        array_push($newReport, floatval($total));

        $html = view('pdfs.invoicereport')->with('report', $newReport);
        return $this->pdf
            ->load($html)
            ->show();
    }
}
