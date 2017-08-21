<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Models\Book, Bishopm\Connexion\Models\Transaction, Bishopm\Connexion\Models\Supplier, Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\Setting, DB;
use Bishopm\Connexion\Mail\MonthlyBookshopMail;
use Illuminate\Support\Facades\Mail;

class MonthlyBookshopEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connexion:bookshopemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly book sales and stock emails';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $suppliers=Supplier::all();
        $data['subject']="Monthly sales and stock report: " . date("M Y", strtotime("first day of previous month"));
        foreach ($suppliers as $supplier) {
            $data['costofsalestotal'][$supplier->supplier]=0;
            $data['salestotal'][$supplier->supplier]=0;
            $data['stockvalue'][$supplier->supplier]=0;
            $data['deliveries'][$supplier->supplier]=array();
            $data['sales'][$supplier->supplier]=array();
        }
        $startdate=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $enddate=date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        $transactions=Transaction::with('book')->where('transactiondate','>=',$startdate)->where('transactiondate','<',$enddate)->get();
        foreach ($transactions as $transaction) {
            if (($transaction->transactiontype<>"Add stock") and ($transaction->transactiontype<>"Shrinkage")){
                $data['sales'][$transaction->book->supplier->supplier][]=$transaction;
                $data['salestotal'][$transaction->book->supplier->supplier]=$data['salestotal'][$transaction->book->supplier->supplier]+$transaction->unitamount*$transaction->units;
                $data['costofsalestotal'][$transaction->book->supplier->supplier]=$data['costofsalestotal'][$transaction->book->supplier->supplier]+$transaction->units*$transaction->book->costprice;
            } elseif ($transaction->transactiontype=="Add stock") {
                $data['deliveries'][$transaction->book->supplier->supplier][]=$transaction;
            } else {
                $data['shrinkage'][$transaction->book->supplier->supplier][]=$transaction;
            }
        }
        $books=Book::where('stock','>',0)->orderBy('title','ASC')->get();
        foreach ($books as $book){
            $data['stock'][$book->supplier->supplier][]=$book;
            $data['stockvalue'][$book->supplier->supplier]=$data['stockvalue'][$book->supplier->supplier]+$book->costprice;
        }
        // Send to bookshop group
        $setting=Setting::where('setting_key','bookshop')->first()->setting_value;
        if ($setting){
            $churchemail=Setting::where('setting_key','church_email')->first()->setting_value;
            $group=Group::with('individuals')->find($setting);
            if ($group){
                foreach ($group->individuals as $recip){
                    $data['recipient']=$recip->firstname;
                    $data['subject']="Bookshop sales and stock report: " . date("M Y", strtotime("first day of previous month"));
                    $data['sender']=$churchemail;
                    Mail::to($recip->email)->send(new MonthlyBookshopMail($data));
                }
            }
        }
    }
}
