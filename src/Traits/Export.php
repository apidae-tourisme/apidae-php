<?php

namespace ApidaePHP\Traits;

use Exception;
use ZipArchive;
use Symfony\Component\Finder\Finder;

trait Export
{
    /**
     * Download and read zip export
     *
     * @param  array<mixed> $params
     * @return \Symfony\Component\Finder\Finder
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getExportFiles(array $params): Finder
    {
        $client = $this->getHttpClient();

        if (empty($params['url'])) {
            if (isset($params['urlRecuperation'])) {
                $params['url'] = $params['urlRecuperation'];
            } else {
                throw new \InvalidArgumentException("Missing 'url' parameter! Must be the 'urlRecuperation' you got from the notification.");
            }
        }

        if (preg_match('/\.zip$/i', $params['url']) !== 1) {
            throw new \InvalidArgumentException("'url' parameter does not looks good! Must be the 'urlRecuperation' you got from the notification.");
        }

        $temporaryDirectory = $this->getExportDirectory();
        $exportPath         = sprintf('%s/%s', $temporaryDirectory, date('Y-m-d-His'));
        $zipFullPath        = sprintf('%s/export.zip', $exportPath);
        $exportFullPath     = sprintf('%s/export/', $exportPath);

        mkdir($exportPath);
        mkdir($exportFullPath);

        if (!is_dir($exportFullPath)) {
            throw new Exception('Directory does not exists : ' . $exportFullPath);
        }
        if (!is_writable($exportFullPath)) {
            throw new Exception('Directory is not writable : ' . $exportFullPath);
        }

        $resource = fopen($zipFullPath, 'w');

        // Download the ZIP file in temp directory
        try {
            $client->request('GET', $params['url'], ['sink' => $resource]);
        } catch (\Exception $e) {
            $this->handleHttpError($e);
        }

        $zip = new ZipArchive;
        $res = $zip->open($zipFullPath);
        if ($res !== true) {
            throw new Exception('Invalid zip file');
        }

        $zip->extractTo($exportFullPath);
        $zip->close();

        $finder = new Finder();
        $finder->in($exportFullPath);
        return $finder;
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
            $exportDirectory,
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
     * @return string
     */
    private function getExportDirectory(): string
    {
        if (!file_exists($this->config['exportDir'])) {
            mkdir($this->config['exportDir']);
        }

        $dir = $this->config['exportDir'];

        if (!is_dir($dir) || !is_writeable($dir)) {
            throw new \InvalidArgumentException($dir . ' is not a directory or is not writeable');
        }

        return $dir;
    }
}
