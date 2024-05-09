<?php

namespace App\Console\Commands;

use App\Models\ProductEntry;
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
    protected $description = 'Checks all product entries for upcoming expiry and sends alerts.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        ExpiryAlert::whereHas('productEntry', function ($query) {
            $query->where('quantity', '=', 0);
        })->delete();

        $this->info('Irrelevant expiry alerts cleaned up.');
        $dateInOneWeek = now()->addWeek();

        // Fetch product entries that are expiring within one week and have quantity remaining.
        $expiringEntries = ProductEntry::where('expiry_date', '<=', $dateInOneWeek)
            ->where('quantity', '>', 0)  // Check that the entry still has some quantity left
            ->with('product') // Eager load the product
            ->get();

        foreach ($expiringEntries as $entry) {
            if (!$entry->product) {
                continue; // Skip if no product is associated (optional safeguard)
            }

            // Check and create alert if not already notified.
            $alert = ExpiryAlert::firstOrCreate(
                ['product_entry_id' => $entry->id],
                ['notified' => false]
            );

            if (!$alert->notified) {
                // Assuming that MailController is properly set up to handle sending of expiry emails.
                $mailController = new MailController();
                $mailController->send_expiry_date_mail($entry->product, $entry->expiry_date);

                // Mark alert as notified
                $alert->notified = true;
                $alert->save();

                $this->info('Expiry alert sent for product entry ID: ' . $entry->id);
            }
        }

        $this->info('Expiry checks completed.');
    }
}
