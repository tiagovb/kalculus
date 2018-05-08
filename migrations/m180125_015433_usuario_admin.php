<?php

use yii\db\Migration;

/**
 * Class m180125_015433_usuario_admin
 */
class m180125_015433_usuario_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
INSERT INTO user (id, username, email, password_hash, auth_key, confirmed_at, unconfirmed_email, blocked_at, registration_ip, created_at, updated_at, flags, last_login_at) VALUES (1, 'admin', 'admin@interativasoftware.com.br', '$2y$10\$wXJiwLCRqM9b3LO/CQRDU.3tsA3cZB3/K1k7BKgKYaOtoXbgkFLuy', 't7eM-w6bxUppLa8eePa2dH0bndES2YqY', 1516845783, NULL, NULL, NULL, 1516845783, 1516845783, 0, 1516846426);
INSERT INTO profile (user_id, name, public_email, gravatar_email, gravatar_id, location, website, bio, timezone) VALUES (1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('admin', 1, '', NULL, NULL, 1516846634, 1516846634);
INSERT INTO auth_assignment (item_name, user_id, created_at) VALUES ('admin', 1, 1516846723);
SQL;

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180125_015433_usuario_admin cannot be reverted.\n";

        return false;
    }
}
