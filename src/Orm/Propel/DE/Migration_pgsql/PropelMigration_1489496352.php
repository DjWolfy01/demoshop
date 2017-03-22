<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1489496352.
 * Generated on 2017-03-14 12:59:12 by vagrant
 */
class PropelMigration_1489496352
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'zed' => '
BEGIN;

CREATE SEQUENCE "spy_queue_process_pk_seq";

CREATE TABLE "spy_queue_process"
(
    "id_queue_process" INTEGER NOT NULL,
    "server_id" VARCHAR(255) NOT NULL,
    "process_pid" INTEGER NOT NULL,
    "worker_pid" INTEGER NOT NULL,
    "queue_name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_queue_process"),
    CONSTRAINT "spy_queue_process-unique-key" UNIQUE ("server_id","process_pid","queue_name")
);

CREATE INDEX "spy_queue_process-index-key" ON "spy_queue_process" ("server_id","queue_name");

COMMIT;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'zed' => '
BEGIN;

DROP TABLE IF EXISTS "spy_queue_process" CASCADE;

DROP SEQUENCE "spy_queue_process_pk_seq";

COMMIT;
',
);
    }

}