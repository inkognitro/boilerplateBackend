<?php declare(strict_types=1);

namespace App\Resources\AuditLogEvent\Attributes;

use App\Resources\DateTimeAttribute;
use App\Utilities\DateTimeFactory;

final class OccurredAt extends DateTimeAttribute
{
    public static function getKey(): string
    {
        return 'auditLogEvent.occurredAt';
    }

    public static function create(): self
    {
        return new self(DateTimeFactory::create());
    }
}