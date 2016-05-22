<?php

namespace StringDecorator\Value;

class Decoration
{
    /** @var string */
    private $prefix;

    /** @var string */
    private $subject;

    /** @var string */
    private $suffix;

    /**
     * @param string $prefix
     * @param string $subject
     * @param string $suffix
     */
    public function __construct($prefix, $subject, $suffix)
    {
        $this->prefix = $prefix;
        $this->subject = $subject;
        $this->suffix = $suffix;
    }

    /**
     * Get a prefix.
     * 
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get a subject of decoration.
     * 
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get a suffix.
     * 
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Converts a decoration to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix . $this->subject . $this->suffix;
    }
}
