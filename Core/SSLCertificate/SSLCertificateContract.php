<?php


namespace Core\SSLCertificate;


interface SSLCertificateContract
{
    public function getSSLData($domain);
}
