<?php

use yii\db\Migration;


class m191025_171230_create_foreign_keys_table extends Migration
{
    public function safeUp()
{
    $this->createIndex(
        'idx-user-address_id',
        'user',
        'address_id'
    );

    $this->addForeignKey(
        'fk-user-address_id',
        'user',
        'address_id',
        'address',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-news-shop_id',
        'news',
        'shop_id'
    );

    $this->addForeignKey(
        'fk-news-shop_id',
        'news',
        'shop_id',
        'shop',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-product-shop_id',
        'product',
        'shop_id'
    );

    $this->addForeignKey(
        'fk-product-shop_id',
        'product',
        'shop_id',
        'shop',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-product-region_id',
        'product',
        'region_id'
    );

    $this->addForeignKey(
        'fk-product-region_id',
        'product',
        'region_id',
        'region',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-product-category_id',
        'product',
        'category_id'
    );

    $this->addForeignKey(
        'fk-product-category_id',
        'product',
        'category_id',
        'category',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-product',
        'product',
        'manufacture_id'
    );

    $this->addForeignKey(
        'fk-product-manufacture_id',
        'product',
        'manufacture_id',
        'manufacture',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-popular-product_id',
        'popular',
        'product_id'
    );

    $this->addForeignKey(
        'fk-popular-product_id',
        'popular',
        'product_id',
        'product',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-recome-product_id',
        'recome',
        'product_id'
    );

    $this->addForeignKey(
        'fk-recome-product_id',
        'recome',
        'product_id',
        'product',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-favourite-product_id',
        'favourite',
        'product_id'
    );

    $this->addForeignKey(
        'fk-favourite-product_id',
        'favourite',
        'product_id',
        'product',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-favourite-user_id',
        'favourite',
        'user_id'
    );

    $this->addForeignKey(
        'fk-favourite-user_id',
        'favourite',
        'user_id',
        'user',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-follower-shop_id',
        'follower',
        'shop_id'
    );

    $this->addForeignKey(
        'fk-follower-shop_id',
        'follower',
        'shop_id',
        'shop',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-follower-user_id',
        'follower',
        'user_id'
    );

    $this->addForeignKey(
        'fk-follower-user_id',
        'follower',
        'user_id',
        'user',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-address-region_id',
        'address',
        'region_id'
    );

    $this->addForeignKey(
        'fk-address-region_id',
        'address',
        'region_id',
        'region',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order-user_id',
        'order',
        'user_id'
    );

    $this->addForeignKey(
        'fk-order-user_id',
        'order',
        'user_id',
        'user',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order-region_id',
        'order',
        'region_id'
    );

    $this->addForeignKey(
        'fk-order-region_id',
        'order',
        'region_id',
        'region',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order-address_id',
        'order',
        'address_id'
    );

    $this->addForeignKey(
        'fk-order-address_id',
        'order',
        'address_id',
        'address',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order_history-user_id',
        'order_history',
        'user_id'
    );

    $this->addForeignKey(
        'fk-order_history-user_id',
        'order_history',
        'user_id',
        'user',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order_history-region_id',
        'order_history',
        'region_id'
    );

    $this->addForeignKey(
        'fk-order_history-region_id',
        'order_history',
        'region_id',
        'region',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order_history-address_id',
        'order_history',
        'address_id'
    );

    $this->addForeignKey(
        'fk-order_history-address_id',
        'order_history',
        'address_id',
        'address',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order_product-product_id',
        'order_product',
        'product_id'
    );

    $this->addForeignKey(
        'fk-order_product-product_id',
        'order_product',
        'product_id',
        'product',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-order_product-order_id',
        'order_product',
        'order_id'
    );

    $this->addForeignKey(
        'fk-order_product-region_id',
        'order_product',
        'order_id',
        'order',
        'id',
        'CASCADE'
    );
}



    /**
     * {@inheritdoc}
     */
    public function safeDown()
{
    echo "m191023_103737_create_foreignKeys cannot be reverted.\n";

    return false;
}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191023_103737_create_foreignKeys cannot be reverted.\n";

        return false;
    }
    */
}