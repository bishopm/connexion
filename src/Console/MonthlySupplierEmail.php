<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Models\Book;
use Bishopm\Connexion\Models\Transaction;
use Bishopm\Connexion\Models\Supplier;
use Bishopm\Connexion\Models\Setting;
use DB;
use Bishopm\Connexion\Mail\MonthlySupplierMail;
use Illuminate\Support\Facades\Mail;

class MonthlySupplierEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connexion:supplieremails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly supplier sale and stock emails';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $suppliers=Supplier::all();
        foreach ($suppliers as $supplier) {
            $data[$supplier->id]['email']=$supplier->email;
            $data[$supplier->id]['supplier']=$supplier->supplier;
            $data[$supplier->id]['costofsalestotal']=0;
            $data[$supplier->id]['salestotal']=0;
            $data[$supplier->id]['stockvalue']=0;
            $data[$supplier->id]['subject']="Monthly sales and stock report: " . date("M Y", strtotime("first day of previous month"));
            $data[$supplier->id]['deliveries']=array();
            $data[$supplier->id]['sales']=array();
            $data[$supplier->id]['stock']=array();
            $data[$supplier->id]['shrinkage']=array();
            $data[$supplier->id]['shrinkagetotal']=0;
        }
        $startdate=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $enddate=date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        $transactions=Transaction::with('book')->where('transactiondate', '>=', $startdate)->where('transactiondate', '<=', $enddate)->get();
        foreach ($transactions as $transaction) {
            if ($transaction->transactiontype=="Shrinkage") {
                $data[$transaction->book->supplier_id]['shrinkage'][$transaction->book->id]['book']=$transaction->book;
                if (!isset($data[$transaction->book->supplier_id]['shrinkage'][$transaction->book->id]['units'])) {
                    $data[$transaction->book->supplier_id]['shrinkage'][$transaction->book->id]['units']=0;
                }
                $data[$transaction->book->supplier_id]['shrinkage'][$transaction->book->id]['units']=$data[$transaction->book->supplier_id]['shrinkage'][$transaction->book->id]['units']+$transaction->units;
                $data[$transaction->book->supplier_id]['shrinkagetotal']=$data[$transaction->book->supplier_id]['shrinkagetotal']+$transaction->units*$transaction->book->costprice;
            } elseif ($transaction->transactiontype=="Add stock") {
                $data[$transaction->book->supplier_id]['deliveries'][$transaction->book->id]['book']=$transaction->book;
                if (!isset($data[$transaction->book->supplier_id]['deliveries'][$transaction->book->id]['units'])) {
                    $data[$transaction->book->supplier_id]['deliveries'][$transaction->book->id]['units']=0;
                }
                $data[$transaction->book->supplier_id]['deliveries'][$transaction->book->id]['units']=$data[$transaction->book->supplier_id]['deliveries'][$transaction->book->id]['units']+$transaction->units;
            } else {
                $data[$transaction->book->supplier_id]['sales'][$transaction->book->id]['book']=$transaction->book;
                if (!isset($data[$transaction->book->supplier_id]['sales'][$transaction->book->id]['units'])) {
                    $data[$transaction->book->supplier_id]['sales'][$transaction->book->id]['units']=0;
                }
                $data[$transaction->book->supplier_id]['sales'][$transaction->book->id]['units']=$data[$transaction->book->supplier_id]['sales'][$transaction->book->id]['units']+$transaction->units;
                $data[$transaction->book->supplier_id]['salestotal']=$data[$transaction->book->supplier_id]['salestotal']+$transaction->unitamount*$transaction->units;
                $data[$transaction->book->supplier_id]['costofsalestotal']=$data[$transaction->book->supplier_id]['costofsalestotal']+$transaction->units*$transaction->book->costprice;
            }
        }
        $books=Book::where('stock', '>', 0)->orderBy('title', 'ASC')->get();
        foreach ($books as $book) {
            $data[$book->supplier_id]['stock'][]=$book;
            $data[$book->supplier_id]['stockvalue']=$data[$book->supplier_id]['stockvalue']+$book->costprice;
        }
        foreach ($data as $supplierdata) {
            if (($supplierdata['salestotal']) or ($supplierdata['stock'])) {
                Mail::to($supplierdata['email'])->send(new MonthlySupplierMail($supplierdata));
            }
        }
    }
}
