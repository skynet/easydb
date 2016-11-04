<?php

namespace ParagonIE\EasyDB\Tests;

use InvalidArgumentException;
use PDOException;
class InsertTest extends EasyDBWriteTest
{
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsertNoFieldsThrowsException(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $this->expectException(PDOException::class);
        $this->assertNull($db->insert('irrelevant_but_valid_tablename', []));
    }
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsertTableNameThrowsException(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->insert('', ['foo' => 1]);
    }
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsertMapArgThrowsException(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->insert('irrelevant_but_valid_tablename', [[1]]);
    }
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsertMapArgKeysThrowsException(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->insert('irrelevant_but_valid_tablename', ['1foo' => 1]);
    }
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsertIncorrectFieldThrowsException(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $this->expectException(PDOException::class);
        $db->insert('irrelevant_but_valid_tablename', ['bar' => 1]);
    }
    /**
     * @dataProvider GoodFactoryCreateArgument2EasyDBProvider
     * @param callable $cb
     */
    public function testInsert(callable $cb)
    {
        $db = $this->EasyDBExpectedFromCallable($cb);
        $db->insert('irrelevant_but_valid_tablename', ['foo' => 1]);
        $this->assertEquals($db->single('SELECT COUNT(foo) FROM irrelevant_but_valid_tablename WHERE foo = ?', [1]), '1');
    }
}