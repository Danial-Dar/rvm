<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'reference_number' => $this->reference_number,
            'status' => $this->status,
            'paid_status' => $this->paid_status,
            'tax_per_item' => $this->tax_per_item,
            'discount_per_item' => $this->discount_per_item,
            'notes' => $this->notes,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'discount_val' => $this->discount_val,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'tax' => $this->tax,
            'due_amount' => $this->due_amount,
            'sent' => $this->sent,
            'viewed' => $this->viewed,
            'unique_hash' => $this->unique_hash,
            'sequence_number' => $this->sequence_number,
            'formatted_created_at' => $this->formattedCreatedAt,
            'invoice_pdf_url' => $this->invoicePdfUrl,
            'formatted_invoice_date' => $this->formattedInvoiceDate,
            'formatted_due_date' => $this->formattedDueDate,
            'allow_edit' => $this->allow_edit,
            'sales_tax_type' => $this->sales_tax_type,
            'sales_tax_address_type' => $this->sales_tax_address_type,
            'items' => $this->when($this->items()->exists(), function () {
                return InvoiceItemResource::collection($this->items);
            }),
            'user' => $this->when($this->user()->exists(), function () {
                return new UserResource($this->user);
            }),
            'taxes' => $this->when($this->taxes()->exists(), function () {
                return TaxResource::collection($this->taxes);
            }),
            'company' => $this->when($this->company()->exists(), function () {
                return new CompanyResource($this->company);
            }),
        ];
    }
}
