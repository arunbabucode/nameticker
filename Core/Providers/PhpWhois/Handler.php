<?php

namespace Core\Providers\PhpWhois;

use App\Exceptions\PhpWhoisException;
use Core\Providers\DomainDataContract;
use Core\Providers\WhoisErrorItem;
use Core\Providers\WhoisItem;
use Exception;
use Iodev\Whois\Exceptions\ConnectionException;
use Iodev\Whois\Exceptions\ServerMismatchException;
use Iodev\Whois\Exceptions\WhoisException;
use Iodev\Whois\Factory;
use Iodev\Whois\Loaders\CurlLoader;
use Iodev\Whois\Modules\Tld\TldInfo;
use function env;

class Handler implements DomainDataContract
{
    /**
     * @param $domain
     * @return WhoisErrorItem|WhoisItem
     */
    public function getDomainData($domain)
    {
        try {
            $domainRequest = $this->getRequest($domain);
        } Catch(Exception $e) {
            return WhoisErrorItem::fromArray([
                WhoisErrorItem::MESSAGE => $e->getMessage(),
                WhoisErrorItem::SUCCESS => false
            ]);
        }

        return WhoisItem::fromArray([
            WhoisItem::DOMAIN => $domainRequest->domainName,
            WhoisItem::WHOIS_SERVER => !empty($domainRequest->whoisServer) ? $domainRequest->whoisServer :  null,
            WhoisItem::CREATED_AT => !empty((int)$domainRequest->creationDate) ? $domainRequest->creationDate : null,
            WhoisItem::EXPIRES_AT => !empty((int)$domainRequest->expirationDate) ? $domainRequest->expirationDate : null,
            WhoisItem::UPDATED_AT => !empty((int)$domainRequest->updatedDate) ? $domainRequest->updatedDate : null,
            WhoisItem::OWNER => $domainRequest->owner,
            WhoisItem::REGISTRAR => $domainRequest->registrar,
        ]);
    }

    private function getRequest($domain): TldInfo
    {
        try {
            $whois = Factory::get()->createWhois($this->loadProxyConfiguration());
            $domainRequest = $whois->loadDomainInfo($domain);

            if(empty((int)$domainRequest->expirationDate)) {
                throw new PhpWhoisException('No domain expiration date found.');
            }
            return $whois->loadDomainInfo($domain);

        } catch (ConnectionException $e) {
            throw new PhpWhoisException('Disconnect or connection timeout',);
        } catch (ServerMismatchException $e) {
            throw new PhpWhoisException('TLD server not found in current server hosts');
        } catch (WhoisException | Exception $e) {
            throw new PhpWhoisException('Whois server responded with error '. $e->getMessage());
        }
    }

    private function loadProxyConfiguration(): CurlLoader
    {
        $loader = new CurlLoader();
        if(!$this->shouldUseProxy())  {
            return $loader;
        }
        $loader->replaceOptions([
            CURLOPT_PROXYTYPE => env('PROXY_TYPE'),
            CURLOPT_PROXY => env('PROXY_HOST_PORT'),
            CURLOPT_PROXYUSERPWD => env('PROXY_USER_PWD'),
        ]);
        return $loader;
    }

    /**
     * @return bool
     */
    private function shouldUseProxy()
    {
        return env('ENABLE_PROXY');
    }
}
