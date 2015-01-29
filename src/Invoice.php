<?php

namespace CloudManaged\FreeAgent;

use CloudManaged\FreeAgent\Api\ApiError;
use CloudManaged\FreeAgent\Api\ApiResource;
use CloudManaged\FreeAgent\Errors\InvoiceError;

class Invoice extends ApiResource
{
    public function __construct(FreeAgent $freeAgent)
    {
        parent::__construct($freeAgent);
    }

    public function getInvoiceUrl()
    {
        return $this->baseURL . 'invoices';
    }

    /**
     * Create an invoice
     * An invoice is always created with a status of Draft. You must use the status
     * transitions to mark an invoice as Draft, Sent, Scheduled or Cancelled.
     *
     * @see https://dev.freeagent.com/docs/invoices#create-an-invoice
     * @param $data
     * @return mixed
     */
    public function createAnInvoice($data)
    {
        $response = $this->saveInvoiceDetails($data);
        return $this->responseDetails(json_decode($response));
    }

    protected function saveInvoiceDetails($data)
    {
        try {
            $url = $this->getInvoiceUrl();
            $data = ['invoice' => $data];
            return $this->save($url, $data);
        } catch (ApiError $e) {
            throw new InvoiceError($e);
        }
    }

    /**
     * Mark invoice as sent
     *
     * @see https://dev.freeagent.com/docs/invoices#mark-invoice-as-sent
     * @param $invoiceId
     * @return mixed
     */
    public function markInvoiceAsSent($invoiceId)
    {
        $url = $this->getInvoiceUrl();
        $url = $url . '/' . $invoiceId .'/transitions/mark_as_sent';
        return $this->update($url, []);
    }

    public function emailAnInvoice($invoiceId, $params)
    {
        $url = $this->urlInvoices();
        $url = $url . '/' . $invoiceId .'/send_email';

        $data = ['invoice' => ['email' => $params]];
        return $this->saveProviderData($url, $data);
    }
}
