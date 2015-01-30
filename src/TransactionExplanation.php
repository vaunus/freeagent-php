<?php

namespace CloudManaged\FreeAgent;

use CloudManaged\FreeAgent\Api\ApiResource;
use CloudManaged\FreeAgent\Errors\ApiError;
use CloudManaged\FreeAgent\Errors\TransactionError;

class TransactionExplanation extends ApiResource
{
    public function getBankTransactionExplanationUrl()
    {
        return $this->getUrlBase() . 'bank_transaction_explanations';
    }

    /**
     * Create a Bank Transaction Explanation
     *
     * @param $params
     *
     * @return mixed
     * @throws TransactionError
     */
    public function createBankTransactionExplanation($params)
    {
        try {
            $url = $this->getBankTransactionExplanationUrl();
            $data = ['bank_transaction_explanation' => $params];
            return $this->save($url, $data);
        } catch (ApiError $e) {
            throw new TransactionError($e);
        }
    }
}
