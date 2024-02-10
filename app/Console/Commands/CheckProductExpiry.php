<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ExpiryAlert;
use App\Mail\ExpiryAlertMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MailController;

class CheckProductExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-product-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $dateInOneWeek = now()->addWeek();
    $alerts = ExpiryAlert::all();

    foreach ($alerts as $alert) {
        $product = Product::find($alert->product_id);

        // Check if product still exists and handle accordingly
        if ($product) {
            // Delete alert if product is no longer expiring within a week
            if ($product->expiry_date > $dateInOneWeek) {
                $alert->delete();
            } else {
                // Check if an alert has already been sent
                if (!$alert->notified) {
                    // Send email notification
                    $mailController = new MailController();
                    $mailController->send_expiry_date_mail($product);
                    
                    // Mark alert as notified
                    $alert->notified = true;
                    $alert->save();
                }
            }
        } else {
            // Optionally handle the case where the product no longer exists
        }
    }

    // Additionally, check for and handle any new products that are expiring within a week
    $newExpiringProducts = Product::where('expiry_date', '<=', $dateInOneWeek)
                                  ->whereDoesntHave('expiryAlerts')
                                  ->get();

    foreach ($newExpiringProducts as $product) {
        // Send email notification
        $mailController = new MailController();
        $mailController->send_expiry_date_mail($product);

        // Create a new alert
        ExpiryAlert::create([
            'product_id' => $product->id,
            'expiry_date' => $product->expiry_date,
            'notified' => true
        ]);
    }
}


}
