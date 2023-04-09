<?php

namespace GS\GenericParts\Service;

class GSClipService
{
    public $contents;
    private $os;

    public function __construct()
    {
        $this->os = \php_uname();
    }

    public function copy($contents): void
    {
        $this->contents = \trim($contents);

        if (\preg_match('/windows/i', $this->os)) {
            $this->windows();
            return;
        }
        if (\preg_match('/darwin/i', $this->os)) {
            $this->mac();
            return;
        }
        $this->linux();
    }

    // ###> HELPER ###

    private function mac(): void
    {
        \exec('echo ' . $this->contents . ' | pbcopy');
    }

    private function linux(): void
    {
        \exec('echo ' . $this->contents . ' | xclip -sel clip');
    }

    private function windows(): void
    {
        \exec('echo | set /p="' . $this->contents . '" | clip');
    }
}
