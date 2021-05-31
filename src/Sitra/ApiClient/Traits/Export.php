<?php

namespace Sitra\ApiClient\Traits;

use Mmoreram\Extractor\Extractor;
use Symfony\Component\Finder\Finder;
use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Sitra\ApiClient\Exception\InvalidExportDirectoryException;

trait Export
{


    /**
     * Download and read zip export
     *
     * @param  array                            $params
     * @return \Symfony\Component\Finder\Finder
     */
    public function getExportFiles(array $params): Finder
    {
        $client = $this->getHttpClient();

        if (empty($params['url'])) {
            throw new \InvalidArgumentException("Missing 'url' parameter! Must be the 'urlRecuperation' you got from the notification.");
        }

        if (preg_match('/\.zip$/i', $params['url']) !== 1) {
            throw new \InvalidArgumentException("'url' parameter does not looks good! Must be the 'urlRecuperation' you got from the notification.");
        }

        $temporaryDirectory = $this->getExportDirectory();
        $exportPath         = sprintf('%s/%s', $temporaryDirectory->getDirectoryPath(), date('Y-m-d-His'));
        $zipFullPath        = sprintf('%s/export.zip', $exportPath);
        $exportFullPath     = sprintf('%s/export/', $exportPath);

        mkdir($exportPath);
        mkdir($exportFullPath);

        $resource = fopen($zipFullPath, 'w');

        // Download the ZIP file in temp directory
        try {
            $client->get($params['url'], ['sink' => $resource]);
        } catch (\Exception $e) {
            $this->handleHttpError($e);
        }

        // Extract the ZIP file
        $extractor = new Extractor(
            new SpecificDirectory($exportFullPath)
        );

        return $extractor->extractFromFile($zipFullPath);
    }

    /**
     * Remove all ZIP and exported files from the exportDir (cleanup files we have created)
     *
     * @return bool
     */
    public function cleanExportFiles(): bool
    {
        $exportDirectory = $this->getExportDirectory();

        $iterator = new \RecursiveDirectoryIterator(
            $exportDirectory->getDirectoryPath(),
            \RecursiveDirectoryIterator::SKIP_DOTS
        );

        $files = new \RecursiveIteratorIterator(
            $iterator,
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        return true;
    }

    /**
     * @return SpecificDirectory
     */
    private function getExportDirectory(): SpecificDirectory
    {
        if (!file_exists($this->config['exportDir'])) {
            mkdir($this->config['exportDir']);
        }

        $dir = new SpecificDirectory($this->config['exportDir']);

        if (!$dir) {
            throw new InvalidExportDirectoryException();
        }

        return $dir;
    }
}
