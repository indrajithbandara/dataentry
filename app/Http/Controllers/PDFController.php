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

    public function invoice($id)
    {
        // Get Invoice Data
        $invoice = Invoice::find($id);

        // Array to push to
        $newInvoice = [];

        // Loop over data to construct a new array while decoding encoded json values
        foreach($invoice['original'] as $key => $value){
            if($key === 'customer' || $key === 'line_items'){
                $d_decoded = json_decode(json_decode($value, true));
                array_push($newInvoice, $d_decoded);
            } else {
                array_push($newInvoice, $value);
            }
        }

        $html = view('pdfs.invoice')->with('invoice', $newInvoice);

        return $this->pdf
            ->load($html)
            ->show();
    }
}
