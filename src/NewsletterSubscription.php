<?php

namespace Dovile\Newsletter;

use League\Csv\CannotInsertRecord;
use League\Csv\Reader;
use League\Csv\Writer;

class NewsletterSubscription
{
    private string $error = '';
    private string $fileName = 'file.csv';

    public function saveEmail(string $email): bool
    {
        if (!$this->createFileIfNotExists()) {
            $this->error = 'Oops, something went wrong';
            return false;
        }
        if ($this->checkIfEmailExists($email)) {
            $this->error = 'This email already exists. Enter a new one.';
            return false;
        }
        if (!$this->saveToFile($email)) {
            $this->error = 'Oops, something went wrong';
            return false;
        }
        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }

    private function createFileIfNotExists(): bool
    {
        if (file_exists($this->fileName)) {
            return true;
        }
        $content = [
            ['email'],
            [] // Adds new line to the file.
        ];
        $csv = Writer::createFromPath($this->fileName, 'a');
        try {
            $csv->insertAll($content);
            return true;
        } catch (CannotInsertRecord $e) {

        }
        return false;
    }

    private function checkIfEmailExists($email): bool
    {
        $csv = Reader::createFromPath($this->fileName, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            if ($record['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    private function saveToFile($email): bool
    {
        $content = [
            [$email]
        ];

        $csv = Writer::createFromPath($this->fileName, 'a');
        try {
            $csv->insertAll($content);
            return true;
        } catch (CannotInsertRecord $e) {

        }
        return false;
    }
}
