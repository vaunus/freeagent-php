<?php

namespace CloudManaged\FreeAgent;

use CloudManaged\FreeAgent\Api\ApiResource;
use CloudManaged\FreeAgent\Errors\ApiError;
use CloudManaged\FreeAgent\Errors\TransactionError;

class Transaction extends ApiResource
{
    public function getBankTransactionUrl()
    {
        return $this->getUrlBase() . 'bank_transactions';
    }

    /**
     * List all Bank Transactions by Bank Account
     *
     * @see https://dev.freeagent.com/docs/bank_transactions
     * @param $params will be an array of different params to filter the request as such:
     *                  - Date filters
     *                      - from_date (=)
     *                      - to_date (=)
     *                  - View filters (view=)
     *                      - unexplained
     *                      - manual
     *                      - imported
     *
     * @return mixed
     * @throws TransactionError
     */
    public function listAllBankTransactionsByBankAccount($params)
    {
        try {
            $url = $this->getBankTransactionUrl();
            return $this->retrieve($url, [], $params);
        } catch (ApiError $e) {
            throw new TransactionError($e);
        }
    }

    /**
     * Get a single invoice
     *
     * @see https://dev.freeagent.com/docs/invoices
     * @param $id
     *
     * @return mixed
     * @throws TransactionError
     */
    public function getASingleBankTransaction($id)
    {
        try {
            $url = $this->getBankTransactionUrl() . '/' . $id;
            return $this->retrieve($url, []);
        } catch (ApiError $e) {
            throw new TransactionError($e);
        }
    }
}
