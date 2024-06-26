<?php

namespace Database\Seeders;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\TicketGroupEnum;
use App\Enums\TransactionStatusEnum;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\TransactionTicket;
use App\Models\User;
use App\Utils\QrCode;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker               = Factory::create('id_ID');
        $customers           = User::whereHasMorph('userable', [Customer::class])->get();
        $tickets             = Ticket::all();
        $groups              = collect(TicketGroupEnum::cases());
        $transactionStatuses = collect(TransactionStatusEnum::cases());

        foreach (range(1, 10) as $_) {
            DB::transaction(function () use ($faker, $groups, $transactionStatuses, $customers, $tickets) {
                /**
                 * @var TransactionStatusEnum $status
                 * @var User $customer
                 */
                $status   = $transactionStatuses->random();
                $customer = $customers->random();

                // get random date for transaction
                $transactionDate = now()->addDays(rand(-20, 20))->toDateTimeString();

                // get random ticket want to buy
                $transactionTickets = $tickets->shuffle()->take(rand(1, 3));

                $transaction = new Transaction([
                    "identity_number"    => $customer->userable->identity_number,
                    "customer_name"      => $faker->name,
                    "customer_email"     => $faker->email,
                    "customer_phone"     => $faker->numerify("+62#############"),
                    "transaction_code"   => $faker->uuid,
                    "booking_date"       => $transactionDate,
                    "transaction_status" => $status->value,
                    "number_of_tickets"  => $transactionTickets->count(),
                ]);
                $transaction->saveFile('qr_code_image', QrCode::createQrCodeImage($transaction->constructValidateQrCodeUrl()), $transaction->qrCodeImagePath());
                $transaction->user()->associate($customer);
                $transaction->save();

                // create transaction ticket and their qr code,
                // why should create qr_code_image? what if customer want to scan it differently?
                foreach ($transactionTickets as $item) {
                    $transactionTicket = new TransactionTicket(array_merge($item->only('name', 'price'), [
                        "transaction_code" => $faker->uuid,
                    ]));
                    $transactionTicket->transaction()->associate($transaction);
                    $transactionTicket->setQuantityAttribute(rand(1, 3));
                    $transactionTicket->saveFile('qr_code_image', QrCode::createQrCodeImage($transactionTicket->constructValidateQrCodeUrl()), $transactionTicket->qrCodeImagePath());
                    $transactionTicket->save();
                }

                // we don't want to create payment if it's pending
                if ($status->isPending()) {
                    return;
                }

                $payment = new Payment([
                    "payment_method" => PaymentMethodEnum::BANK_TRANSFER->value,
                    "payment_status" => PaymentStatusEnum::SUCCESS->value,
                ]);
                $payment->saveFile('payment_proof_image', UploadedFile::fake()->image('test.jpg', 500, 500), $payment->fullPath());
                $payment->transaction()
                    ->associate($transaction)
                    ->save();
            });
        }
    }
}
