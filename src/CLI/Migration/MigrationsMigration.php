<?php declare(strict_types=1);

namespace App\CLI\Migration;

use App\Packages\Common\Installation\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class MigrationsMigration extends AbstractMigration
{
    public function getBatchNumber(): int
    {
        return 1;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('migrations');
        $table->addColumn('class_name', Type::STRING);
        $table->addColumn('batch_number', Type::INTEGER);
        $table->addColumn('executed_at', Type::DATETIME);
        $table->setPrimaryKey(['class_name']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('migrations');
    }
}