<?php declare(strict_types=1);

namespace App\Packages\Common\Application\Validation;

interface Message
{
    public function getCode(): string;
    public function getMessage(): string;
}