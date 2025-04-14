<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class EnableUuidOsspExtension extends AbstractMigration
{
    public function up(): void
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
    }

    public function down(): void
    {
        $this->execute('DROP EXTENSION IF EXISTS "uuid-ossp";');
    }
}
