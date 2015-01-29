<?php

namespace CloudManaged\FreeAgent;

use CloudManaged\FreeAgent\ApiResource;

class Contact extends ApiResource
{
    public function __construct(FreeAgent $freeAgent)
    {
        parent::__construct($freeAgent);
    }

    public function urlContacts()
    {
        return $this->baseURL . 'contacts';
    }

    protected function contactDetails($response)
    {
        $response = (array)($response->contact);
        $contact = new Contact($response);

        return $contact;
    }

    /**
     * Create contact
     *
     * @param $params
     * @return \Guzzle\Http\EntityBodyInterface|string
     * @throws IDPException
     */
    public function createContact($params)
    {
        $url = $this->urlContacts();

        $data = ['contact' => $params];
        return $this->saveProviderData($url, $data);
    }

    /**
     * Update contact
     *
     * @param $params
     * @param null $contactId
     * @return \Guzzle\Http\EntityBodyInterface|string
     * @throws IDPException
     */
    public function updateContact($params, $contactId = null)
    {
        $url = $this->urlContacts() . '/' . $contactId;

        $data = ['contact' => $params];
        return $this->updateProviderData($url, $data);
    }
}
