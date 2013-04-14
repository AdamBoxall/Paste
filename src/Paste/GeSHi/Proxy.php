<?php

namespace Paste\GeSHi;

class Proxy
{
    public function parse($source, $syntax)
    {
        return $this->createGeshi($source, $syntax)->parse_code();
    }

    protected function createGeshi($source, $syntax)
    {
        $geshi = new GeSHi($source, $syntax);
        $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
        $geshi->set_language_path(__DIR__ . '/languages');

        return $geshi;
    }
}