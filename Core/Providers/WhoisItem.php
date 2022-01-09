<?php

namespace Core\Providers;


use Carbon\Carbon;

class WhoisItem
{
    const DOMAIN = 'domain';
    const WHOIS_SERVER = 'whois_server';
    const CREATED_AT = 'created_at';
    const EXPIRES_AT = 'expires_at';
    const UPDATED_AT = 'updated_at';
    const OWNER = 'owner';
    const REGISTRAR = 'registrar';

    CONST DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string|null
     */
    private $whoisServer;

    /**
     * @var Carbon|null
     */
    private $createdAt;

    /**
     * @var Carbon|null
     */
    private $expiresAt;

    /**
     * @var Carbon|null
     */
    private $updatedAt;

    /**
     * @var string|null
     */
    private $owner;

    /**
     * @var string|null
     */
    private $registrar;

    private function __construct(
        string $domain,
        string $whoisServer = null,
        Carbon $createdAt = null,
        Carbon $expiresAt = null,
        Carbon $updatedAt = null,
        string $owner = null,
        string $registrar = null
    )
    {
        $this->domain = $domain;
        $this->whoisServer = $whoisServer;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
        $this->updatedAt = $updatedAt;
        $this->owner = $owner;
        $this->registrar = $registrar;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string|null
     */
    public function getWhoisServer(): ?string
    {
        return $this->whoisServer;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon|null
     */
    public function getExpiresAt(): ?Carbon
    {
        return $this->expiresAt;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return string|null
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * @return string|null
     */
    public function getRegistrar(): ?string
    {
        return $this->registrar;
    }

    public static function fromArray(array $data): WhoisItem
    {
        return new self(
            $data[self::DOMAIN],
            $data[self::WHOIS_SERVER],
            isset($data[self::CREATED_AT]) ? Carbon::parse($data[self::CREATED_AT]) : null,
            isset($data[self::EXPIRES_AT]) ? Carbon::parse($data[self::EXPIRES_AT]) : null,
            isset($data[self::UPDATED_AT]) ? Carbon::parse($data[self::UPDATED_AT]) : null,
            isset($data[self::OWNER]) ? $data[self::OWNER] : null,
            isset($data[self::REGISTRAR]) ? $data[self::REGISTRAR] : null,
        );
    }

    public function toArray(): array
    {
        return [
            self::DOMAIN => $this->domain,
            self::WHOIS_SERVER => $this->whoisServer,
            self::CREATED_AT => $this->createdAt ? $this->createdAt->format(self::DATE_FORMAT) : null,
            self::EXPIRES_AT => $this->expiresAt ? $this->expiresAt->format(self::DATE_FORMAT) : null,
            self::UPDATED_AT => $this->updatedAt ? $this->updatedAt->format(self::DATE_FORMAT) : null,
            self::OWNER => $this->owner ? $this->owner : null,
            self::REGISTRAR => $this->registrar ? $this->registrar : null,
        ];
    }
}
