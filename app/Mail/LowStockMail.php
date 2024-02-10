<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Product; // Import the Product model at the top

class LowStockMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product; // Add a public property for the product

    /**
     * Create a new message instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product; // Assign the passed product to the property
    }

    public function build()
    {
        return $this->view('emails.low_stock_email') // Use the 'email' view
                   ->with([
                       'productName' => $this->product->name // Pass the product name to the view
                       // You can pass other product details if needed
                   ]);
    }
}
