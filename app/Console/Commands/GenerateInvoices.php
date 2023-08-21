<?php

namespace App\Console\Commands;

use App\Http\Requests\InvoicesRequest;
use App\Models\Invoice;
use App\Services\SerialNumberFormatter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        // create view or get stats .
        // create invoice -> create invoice items -> (cc, number purchase, incoming calls)
        // create payload of above and send to createInvoice function.

        $sql = "
(
    SELECT cc.updated_at::DATE,
           cc.user_id,
           cc.company_id,
           COUNT(*)                                AS quantity,
           UPPER(c.campaign_type) AS type,
           c.name,
           us.value        AS company_unit_price,
           s.call_price    AS unit_price,
           SUM(price)      AS price
    FROM campaign_contacts cc
             LEFT JOIN campaigns c ON c.id = cc.campaign_id
             LEFT JOIN user_settings us ON cc.user_id = us.user_id AND us.key = (CONCAT(c.campaign_type, '_call_price'))
             LEFT JOIN api_settings s ON s.slug = c.campaign_type
    WHERE cc.status = 'initiated'
      AND cc.updated_at::DATE = (NOW() - interval '1 day')::DATE
    GROUP BY cc.updated_at::DATE, cc.user_id, cc.company_id, c.campaign_type, c.name, us.value, s.call_price
    ORDER BY cc.user_id, cc.company_id, type
)
UNION
(
    SELECT mn.created_at::DATE,
           mn.user_id,
           mn.company_id,
           COUNT(*)                                AS quantity,
           'PHONE'                                 AS type,
           'Number Purchase'                       AS name,
           NULL                                    AS company_unit_price,
           us.value::DECIMAL                       AS unit_price,
           (COUNT(*)::DECIMAL * us.value::DECIMAL) AS price
    FROM my_numbers mn
             LEFT JOIN company_settings us ON mn.company_id = us.company_id AND us.option = 'number_price'
    WHERE mn.created_at::DATE = (NOW() - interval '1 day')::DATE
    GROUP BY mn.created_at::DATE, mn.user_id, mn.company_id, us.value
    ORDER BY mn.user_id, mn.company_id, type
)
        ";
        $billableItems = DB::select(DB::raw($sql));

        $inv = [];
        $items = [];
        foreach ($billableItems as $key => $billableItem) {
            $sequenceNumber = (new SerialNumberFormatter())
                ->setModel(new Invoice())
                ->setCompany($billableItem->company_id)
                ->setNextNumbers();
            $user_id = $billableItem->user_id;
            $company_id = $billableItem->company_id;
            $unit_price = $billableItem->company_unit_price??  $billableItem->unit_price;

            $item = [
                'name' => strtoupper($billableItem->type),
                'description' => strtoupper($billableItem->type) . ' - ' . $billableItem->name,
                'price' => (float) $unit_price,
                'company_id' => $company_id,
                'user_id' => $user_id,
                'quantity' => (float) $billableItem->quantity,
                'total' => (float) $unit_price * (float) $billableItem->quantity,
                'discount_type' => 'zero',
                'discount_val' => 0,
                'discount' => 0,
                'tax' => 0,
            ];

            $inv[$user_id] = [
                'invoice_date' => Carbon::now()->format('Y-m-d'),
                'due_date' => Carbon::now()->format('Y-m-d'),
                'invoice_number' => $sequenceNumber->getNextNumber(),
                'user_id' => $user_id,
                'company_id' => $company_id,
                'sub_total' => 100,
                'total' => 100,
                'discount_type' => 'zero',
                'discount_val' => 0,
                'discount' => 0,
                'tax' => 0,
            ];
            $items[] = $item;
        }
        foreach ($items as $key => $item) {
            $inv[$item['user_id']]['items'][] = $item;
        }

        foreach ($inv as $key => $invoice) {
            $sub_total = 0;
            $total = 0;
            foreach ($invoice['items'] as $item) {
                $sub_total = $sub_total + $item['total'];
                $total = $total + $item['total'];
            }
            $inv[$key]['sub_total'] = (float) $sub_total;
            $inv[$key]['total'] = (float) $total;

        }

        foreach ($inv as $key => $invoice) {
            $payload = new InvoicesRequest($invoice);
            $invoice = Invoice::createInvoice($payload);
            $invoice->status = Invoice::STATUS_DUE;
            $invoice->save();
        }


    }

}
