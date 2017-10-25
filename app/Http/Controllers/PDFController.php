<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Vsmoraes\Pdf\Pdf;

class PDFController extends Controller
{
    private $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /*
    * PDF INVOICES
    *
    * params: $id of the invoice
    *
    */
    public function invoice($id)
    {
        // Get Invoice Data by id
        $invoice = Invoice::find($id);
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
                $d_decoded = json_decode(json_decode($value, true));
                /*
                * Both the 'customers' and 'line_items' are looped over but the one that matters most is the 'shipto' and 'billto' keys.
                * This is so they can be converted to an array by exploding the string evertime the '#' symbol is detected. This is 
                * explained on the 'customers.vue' file. In short, '#' is a special character that allows the user to decide when they
                * want a line break when composin the address for their customers. This allows for more customization as the address
                * information needs to be procises for packaging and mailing. 
                */
                foreach($d_decoded as $k => $v){
                    if($k === 'shipto' || $k === 'billto'){
                        $addressArr = explode('#', $v);
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
        * lastly, a 'sub total' value is needed for the invoice information. The total property includes the shipping already.
        * This math is handled on the frontend of the invoice section. Here, we create a new array value to passed on to the pdf
        * template. 
        */
        $sub_total = floatval($invoice['original']['total']) - floatval($invoice['original']['ship_fee']);
        array_push($newInvoice, $sub_total);

        /*
        * Finally, the view and the newInvoice data is stored in a variable to be passed to the PDF objects instance for pdf
        * generation. 
        */
        $html = view('pdfs.invoice')->with('invoice', $newInvoice);
        return $this->pdf
            ->load($html)
            ->show();
    }


    /*
    * PDF SHIPPER
    *
    * params: $id of the invoice
    *
    */
    public function shipper($id)
    {
        // Get Invoice Data by id
        $invoice = Invoice::find($id);
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
                $d_decoded = json_decode(json_decode($value, true));
                /*
                * Both the 'customers' and 'line_items' are looped over but the one that matters most is the 'shipto' and 'billto' keys.
                * This is so they can be converted to an array by exploding the string evertime the '#' symbol is detected. This is 
                * explained on the 'customers.vue' file. In short, '#' is a special character that allows the user to decide when they
                * want a line break when composin the address for their customers. This allows for more customization as the address
                * information needs to be procises for packaging and mailing. 
                */
                foreach($d_decoded as $k => $v){
                    if($k === 'shipto' || $k === 'billto'){
                        $addressArr = explode('#', $v);
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
        * Finally, the view and the newInvoice data is stored in a variable to be passed to the PDF objects instance for pdf
        * generation. 
        */
        $html = view('pdfs.shipper')->with('invoice', $newInvoice);
        return $this->pdf
            ->load($html)
            ->show();
    }
}