<?php


namespace Core\SSLCertificate;


use Spatie\SslCertificate\SslCertificate;

class CertificateHandler implements SSLCertificateContract
{
    const TIMEOUT_SECONDS = 60;

    public function getSSLData($domain)
    {
        try {
            $sslDetails = $this->getCertificateDetails($domain);

            return SSLCertificateItem::fromArray([
                SSLCertificateItem::DOMAIN => $sslDetails->getDomain(),
                SSLCertificateItem::IS_VALID => $sslDetails->isValid(),
                SSLCertificateItem::EXPIRES_IN_DAYS => $sslDetails->expirationDate()->diffInDays(),
                SSLCertificateItem::ISSUER => $sslDetails->getIssuer(),
                SSLCertificateItem::VALID_FROM => $sslDetails->validFromDate(),
                SSLCertificateItem::EXPIRES_AT => $sslDetails->expirationDate(),
            ]);
        } catch (\Exception $exception) {
            return SSLErrorItem::fromArray([
                SSLErrorItem::MESSAGE => $exception->getMessage(),
                SSLErrorItem::SUCCESS => false,
            ]);
        }
    }

    private function getCertificateDetails($domain): SslCertificate
    {
        return SslCertificate::createForHostName($domain, self::TIMEOUT_SECONDS, false);
    }

}
