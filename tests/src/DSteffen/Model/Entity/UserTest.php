<?php
namespace DSteffen\Model\Entity;

use PHPUnit\Framework\TestCase;
/**
 * @backupGlobals disabled
 */
class UserTest extends TestCase {
    
    protected $user;
    protected $testdata;
    
    public function setUp() {
        $this->testdata = [
            "id" => 4,
            "user" => "test1",
            "password" => "test2",
            "roles" => "test3",
            "created_at" => "2010-10-10 10:10:10",
            "updated_at" => "2011-10-10 10:10:10"
        ];
        $this->user = new \DSteffen\Model\Entity\User($this->testdata);
    }

    public function testAllValuesCanBeSet() {
        $user = new \DSteffen\Model\Entity\User($this->testdata);
        
        $this->assertEquals($user->getId(), 4);
        $this->assertEquals($user->getUser(), "test1");
        $this->assertEquals($user->getPassword(), "test2");
        $this->assertEquals($user->getRoles(), "test3");
        $this->assertEquals($user->getCreatedAt(), "2010-10-10 10:10:10");
        $this->assertEquals($user->getUpdatedAt(), "2011-10-10 10:10:10");
        
        $user->setUser("test4");
        $user->setPassword("test5");
        $user->setRoles("test6");
        $user->setUpdatedAt("2015-10-10 10:10:10");
        
        $this->assertEquals($user->getUser(), "test4");
        $this->assertEquals($user->getPassword(), "test5");
        $this->assertEquals($user->getRoles(), "test6");
        $this->assertEquals($user->getUpdatedAt(), "2015-10-10 10:10:10");
    }
    
    public function testPossibleToSerializeJson() {
        $this->assertJson($this->user->serialize());   
    }
    
    public function testIsIdReadonly() {
        $this->user->setId(9);
        
        $this->assertEquals($this->user->getId(), 4);
    }
    
    public function testIsCreatedAtReadonly() {
        $this->user->setCreatedAt("2015-10-10 10:10:10");
        
        $this->assertEquals($this->user->getCreatedAt(), "2010-10-10 10:10:10");
    }
}
