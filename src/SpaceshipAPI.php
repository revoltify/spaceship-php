<?php

declare (strict_types = 1);

namespace Spaceship;

use Spaceship\Http\Client;
use Spaceship\Params\CreateContactParams;
use Spaceship\Params\NameserverParams;
use Spaceship\Params\PrivacyProtectionParams;
use Spaceship\Params\TransferLockParams;
use Spaceship\Params\UpdateContactParams;
use Spaceship\Response\AuthCodeResponse;
use Spaceship\Response\ContactResponse;
use Spaceship\Response\CreateContactResponse;
use Spaceship\Response\DomainResponse;
use Spaceship\Response\NameserverResponse;
use Spaceship\Response\PrivacyProtectionResponse;
use Spaceship\Response\TransferLockResponse;
use Spaceship\Response\UpdateContactResponse;

final class SpaceshipAPI
{
    private Client $client;

    private string $apiKey;

    private string $apiSecret;

    /**
     * @param  string  $apiKey  API key for authentication
     * @param  string  $apiSecret  API secret for authentication
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->client = new Client($this->apiKey, $this->apiSecret);
    }

    /**
     * Retrieve domain information
     *
     * @param  string  $domain  The domain name to query
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function domain(string $domain): DomainResponse
    {
        return new DomainResponse(
            $this->client->get(sprintf('domains/%s', $domain))
        );
    }

    /**
     * Update nameserver settings for a domain
     *
     * @param  string  $domain  The domain to update
     * @param  \Spaceship\Params\NameserverParams  $params  Nameserver configuration parameters
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function updateNameserver(string $domain, NameserverParams $params): NameserverResponse
    {
        return new NameserverResponse(
            $this->client->put(
                sprintf('domains/%s/nameservers', $domain),
                $params->toArray()
            )
        );
    }

    /**
     * Retrieve the auth code for domain transfer
     *
     * @param  string  $domain  The domain to get the auth code for
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function authCode(string $domain): AuthCodeResponse
    {
        return new AuthCodeResponse(
            $this->client->get(sprintf('domains/%s/transfer/auth-code', $domain))
        );
    }

    /**
     * Update privacy protection settings
     *
     * @param  string  $domain  The domain to update
     * @param  \Spaceship\Params\PrivacyProtectionParams  $params  Privacy protection configuration
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function updatePrivacyProtection(string $domain, PrivacyProtectionParams $params): PrivacyProtectionResponse
    {
        return new PrivacyProtectionResponse(
            $this->client->put(
                sprintf('domains/%s/privacy/preference', $domain),
                $params->toArray()
            )
        );
    }

    /**
     * Update transfer lock settings
     *
     * @param  string  $domain  The domain to update
     * @param  \Spaceship\Params\TransferLockParams  $params  Transfer lock configuration
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function updateTransferLock(string $domain, TransferLockParams $params): TransferLockResponse
    {
        return new TransferLockResponse(
            $this->client->put(
                sprintf('domains/%s/transfer/lock', $domain),
                $params->toArray()
            )
        );
    }

    /**
     * Create a new contact
     *
     * @param  \Spaceship\Params\CreateContactParams  $params  Contact information
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function createContact(CreateContactParams $params): CreateContactResponse
    {
        return new CreateContactResponse(
            $this->client->put('contacts', $params->toArray())
        );
    }

    /**
     * Get a contact details
     *
     * @param  string  $contactId  Contact ID
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function contact(string $contactId): ContactResponse
    {
        return new ContactResponse(
            $this->client->get(
                sprintf('contacts/%s', $contactId)
            )
        );
    }

    /**
     * Update a contact with new details
     *
     * @param  string  $domain  The domain to update
     * @param  \Spaceship\Params\UpdateContactParams  $params  Contact information
     *
     * @throws \Spaceship\Exception\SpaceshipException
     */
    public function updateContact(string $domain, UpdateContactParams $params): UpdateContactResponse
    {
        return new UpdateContactResponse(
            $this->client->put(
                sprintf('domains/%s/contacts', $domain),
                $params->toArray()
            )
        );
    }
}
