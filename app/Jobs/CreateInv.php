<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repeat_invoice;
use Carbon\Carbon;
use App\Invoice;

class CreateInv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = Carbon::now();
        $rep_invoices = Repeat_invoice::where('date_next_inv', date_format($date, 'Y-m-d'))->get();

        $previousInvoice = Invoice::orderBy('created_at', 'desc')->first();
        if ($previousInvoice && Carbon::parse($previousInvoice->created_at)->format('Y') !== Carbon::today()->format('Y')) {
            $previousInvoice->inv_number = 0;
        }
        $previousFiscalNumber = Invoice::orderBy('inv_number', 'desc')->first();
        foreach ($rep_invoices as $rep_invoice) {
            Invoice::create([
                'type' => $rep_invoice->type,
                'prefix' => null,
                'year' => date('Y'),
                'issued' => 1,
                'inv_number' => $rep_invoice->client_individual == 1 ? null : $previousInvoice->inv_number + 1,
                'fiscal_number' => $rep_invoice->client_individual == 1 ? null : $previousInvoice->fiscal_number + 1,
                'suffix' => null,
                'date' => date_format($date, 'Y-m-d'),
                'time' => date_format($date, 'H:i:s.u'),
                'date_of_payment' => date_format($date, 'Y-m-d'),
                'delivery_date' => date_format($date, 'Y-m-d'),
                'method_of_payment' => $rep_invoice->method_of_payment,
                'operator' => $rep_invoice->operator,
                'reference_number' => $rep_invoice->reference_number,
                'jir' => $rep_invoice->jir,
                'notes' => $rep_invoice->notes,
                'email_text' => $rep_invoice->email_text,
                'client_company' => $rep_invoice->client_company,
                'jib' => $rep_invoice->jib, 
                'client_pdv' => $rep_invoice->client_pdv,
                'client_adderss' => $rep_invoice->client_adderss,
                'client_city' => $rep_invoice->client_city,
                'client_postal_code' => $rep_invoice->client_postal_code,
                'client_email' => $rep_invoice->client_email,
                'suma' => $rep_invoice->sum,
                'goods' => $rep_invoice->goods,
                'lang' => $rep_invoice->lang,
            ]);

            $dateNexInv = Carbon::parse($rep_invoice->date_first_inv);
            $frequency = intval($rep_invoice->frequency);
            $dateNexInv = $dateNexInv->addMonths($frequency);

            $rep_invoice->date_next_inv = $dateNexInv;
            $rep_invoice->save();
        }
    }
}
