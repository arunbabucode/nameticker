<?php


namespace Core\SSLCertificate;


use Carbon\Carbon;

class SSLCertificateItem
{
    const DOMAIN = 'domain';
    const ISSUER = 'issuer';
    const IS_VALID = 'is_valid';
    const VALID_FROM = 'valid_from';
    const EXPIRES_AT = 'expires_at';
    const EXPIRES_IN_DAYS = 'expires_in_days';

    CONST DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $domain;
    /**
     * @var string|null
     */
    private $issuer;
    /**
     * @var bool
     */
    private $isValid;
    /**
     * @var Carbon|null
     */
    private $validFrom;
    /**
     * @var Carbon|null
     */
    private $expiresAt;
    /**
     * @var int
     */
    private $expiresInDays;

    private function __construct(
        string $domain,
        bool $isValid,
        Int $expiresInDays,
        string $issuer = null,
        Carbon $validFrom = null,
        Carbon $expiresAt = null
    )
    {
        $this->domain = $domain;
        $this->isValid = $isValid;
        $this->expiresInDays = $expiresInDays;
        $this->issuer = $issuer;
        $this->validFrom = $validFrom;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return string|null
     */
    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return Carbon|null
     */
    public function getValidFrom(): ?Carbon
    {
        return $this->validFrom;
    }

    /**
     * @return Carbon|null
     */
    public function getExpiresAt(): ?Carbon
    {
        return $this->expiresAt;
    }

    /**
     * @return int
     */
    public function getExpiresInDays(): int
    {
        return $this->expiresInDays;
    }

    public static function fromArray(array $data): SSLCertificateItem
    {
        return new self(
            $data[self::DOMAIN],
            $data[self::IS_VALID],
            $data[self::EXPIRES_IN_DAYS],
            $data[self::ISSUER],
            isset($data[self::VALID_FROM]) ? $data[self::VALID_FROM] : null,
            isset($data[self::EXPIRES_AT]) ? $data[self::EXPIRES_AT] : null,
        );
    }

    public function toArray(): array
    {
        return [
            self::DOMAIN => $this->domain,
            self::IS_VALID => $this->isValid,
            self::EXPIRES_IN_DAYS => $this->expiresInDays,
            self::ISSUER => $this->issuer,
            self::VALID_FROM => $this->validFrom ? $this->validFrom->format(self::DATE_FORMAT) : null,
            self::EXPIRES_AT => $this->expiresAt ? $this->expiresAt->format(self::DATE_FORMAT) : null,
        ];
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

}
