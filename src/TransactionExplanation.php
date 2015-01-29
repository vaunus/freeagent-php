<?php

namespace CloudManaged\FreeAgent;

class TransactionExplanation
{
    public function urlBankAccounts()
    {
        return $this->baseURL . 'bank_accounts';
    }

    public function urlBankTransactionExplanation()
    {
        return $this->baseURL . 'bank_transaction_explanations';
    }

    /**
     * Create a Bank Transaction Explanation
     *
     * @param $params
     * @return \Guzzle\Http\EntityBodyInterface|string
     * @throws IDPException
     */
    public function createBankTransactionExplanation($params)
    {
        $url = $this->urlBankTransactionExplanation();

        $data = ['bank_transaction_explanation' => $params];
        return $this->saveProviderData($url, $data);
    }
}
