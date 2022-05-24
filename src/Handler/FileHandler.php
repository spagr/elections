<?php

declare(strict_types=1);

namespace App\Handler;

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Uid\Ulid;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use ZipArchive;

class FileHandler
{
    /**
     * @var string
     */
    final public const TYPE_TEXT_CSV = 'text/csv';

    /**
     * @var string
     */
    final public const TYPE_ZIP = 'application/zip';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $varFolder,
    ) {
    }

    public function getContent(string $fileUrl, string $contentType): string
    {
        $response = $this->client->request('GET', $fileUrl);

        if (
            $response->getStatusCode() !== 200
            || $response->getHeaders()['content-type'][0] !== $contentType
        ) {
            throw new RuntimeException('Remote data file not found.');
        }

        if ($contentType === self::TYPE_ZIP) {
            return $this->extractZip($response);
        }

        return $response->getContent();
    }

    private function extractZip(ResponseInterface $response): string
    {
        $filePath = $this->varFolder . '/' . (new Ulid())->toRfc4122();
        $fileHandler = fopen($filePath . '.zip', 'xb+');

        foreach ($this->client->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        fclose($fileHandler);
        $zip = new ZipArchive();

        if ($zip->open($filePath . '.zip') !== true) {
            throw new RuntimeException('File unzip error');
        }

        $filename = $zip->getNameIndex(0);
        $zip->extractTo($filePath);
        $zip->close();

        $result = file_get_contents($filePath . '/' . $filename);
        $filesystem = new Filesystem();
        $filesystem->remove([
            $filePath . '.zip',
            $filePath,
        ]);

        return $result;
    }
}
