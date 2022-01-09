<?php


namespace Core\SSLCertificate;


class SSLErrorItem
{
    const MESSAGE = 'message';

    const SUCCESS = 'success';

    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $success;

    /**
     * WhoisErrorItem constructor.
     * @param string $message
     * @param bool $success
     */
    private function __construct(string $message, bool $success)
    {
        $this->message = $message;
        $this->success = $success;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public static function fromArray(array $data): SSLErrorItem
    {
        return new self(
            $data[self::MESSAGE],
            $data[self::SUCCESS]
        );
    }

    public function toArray(): array
    {
        return [
            self::MESSAGE => $this->message,
            self::SUCCESS => $this->success,
        ];
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
