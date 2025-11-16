<?php

namespace App\ValueObjects;

class EmailAddress
{
    private string $email;
    private bool $valid;

    public function __construct(string $email)
    {
        // Standarisasi lowercase
        $this->email = strtolower($email);

        // Validasi email
        $this->valid = filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Ambil nilai email
     */
    public function getValue(): string
    {
        return $this->email;
    }

    /**
     * Cek apakah email valid
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Cek apakah email institusi
     * Hanya dijalankan jika email valid
     */
    public function isInstitutional(): bool
    {
        if (!$this->valid) {
            return false;
        }

        $institutionalDomains = [
            'ac.id',
            'edu',
            'sch.id',
            'go.id',
            'yahoo.com',
        ];

        $domain = explode('@', $this->email)[1] ?? '';

        foreach ($institutionalDomains as $d) {
            if (str_ends_with($domain, $d)) {
                return true;
            }
        }

        return false;
    }
}
