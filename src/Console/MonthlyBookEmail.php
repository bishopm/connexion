<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Models\Book, Bishopm\Connexion\Models\Transaction, Bishopm\Connexion\Models\Supplier;
use Bishopm\Connexion\Models\Setting, DB;
use Bishopm\Connexion\Mail\MonthlyBookMail;
use Illuminate\Support\Facades\Mail;

class MonthlyBookEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connexion:bookemails';

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
        foreach ($suppliers as $supplier) {
            $data[$supplier->id]['email']=$supplier->email;
            $data[$supplier->id]['supplier']=$supplier->supplier;
            $data[$supplier->id]['salestotal']=0;
        }
        $startdate=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $enddate=date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        $transactions=Transaction::with('book')->where('transactiondate','>=',$startdate)->where('transactiondate','<',$enddate)->get();
        foreach ($transactions as $transaction) {
            if (($transaction->transactiontype<>"Add stock") and ($transaction->transactiontype<>"Shrinkage")){
                $data[$transaction->book->supplier_id]['sales'][]=$transaction;
                $data[$transaction->book->supplier_id]['salestotal']=$data[$transaction->book->supplier_id]['salestotal']+$transaction->unitamount*$transaction->units;
            } 
        }
        dd($data);

        // Send to birthday group
        $setting=Setting::where('setting_key','birthday_group')->first()->setting_value;
        $churchname=Setting::where('setting_key','site_name')->first()->setting_value;
        $churchemail=Setting::where('setting_key','church_email')->first()->setting_value;
        $group=Group::with('individuals')->where('groupname',$setting)->first();
        foreach ($group->individuals as $recip){
            $data['recipient']=$recip->firstname;
            $data['subject']="Birthday email from " . $churchname;
            $data['sender']=$churchemail;
            $data['emailmessage']=$msg;
            Mail::to($recip->email)->send(new BirthdayMail($data));
        }
    }
}
