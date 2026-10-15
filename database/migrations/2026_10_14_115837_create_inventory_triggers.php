<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER inventory_transactions_before_insert
            BEFORE INSERT ON inventory_transactions
            FOR EACH ROW
            BEGIN
                DECLARE current_quantity INT DEFAULT 0;

                IF NEW.quantity <= 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Quantity must be greater than zero';
                END IF;

                SELECT quantity INTO current_quantity
                FROM products
                WHERE id = NEW.product_id;

                IF NEW.type IN ('stock_out', 'damaged')
                   AND current_quantity < NEW.quantity THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Insufficient stock';
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER inventory_transactions_after_insert
            AFTER INSERT ON inventory_transactions
            FOR EACH ROW
            BEGIN
                IF NEW.type IN ('stock_in', 'return') THEN
                    UPDATE products
                    SET quantity = quantity + NEW.quantity,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = NEW.product_id;
                ELSEIF NEW.type IN ('stock_out', 'damaged') THEN
                    UPDATE products
                    SET quantity = quantity - NEW.quantity,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = NEW.product_id;
                END IF;
            END
        ");
    }

    public function down()
    {
        DB::unprepared(
            'DROP TRIGGER IF EXISTS inventory_transactions_after_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS inventory_transactions_before_insert'
        );
    }
};