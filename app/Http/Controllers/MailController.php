<?php

namespace App\Http\Controllers;

use App\Mail\OrderStock;
use App\Mail\LowStockMail;
use Illuminate\Http\Request;
use App\Mail\ExpiryAlertMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class MailController extends Controller
{
    public function send_low_stock_mail($product)
    {
        
        try {
            Mail::to('sarahwhite30031003@gmail.com')->send(new LowStockMail($product));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function send_expiry_date_mail($product)
    {
        
        try {
            Mail::to('sarahwhite30031003@gmail.com')->send(new ExpiryAlertMail($product));
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
        }
    }
    
}

