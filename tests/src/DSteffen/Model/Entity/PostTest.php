<?php

namespace DSteffen\Model\Entity;

/**
 * @backupGlobals disabled
 */
class PostTest {
    
    protected $post;
    protected $testdata;
    
    public function setUp() {
        $this->testdata = [
            "id"=>4,
            "title"=>"test1",
            "message"=>"test2",
            "author"=>"test3",
            "created_at" => "2010-10-10 10:10:10",
            "updated_at" => "2011-10-10 10:10:10"
        ];
        $this->post = new \DSteffen\Model\Entity\Post($this->testdata);
    }

    public function testAllValuesCanBeSet() {
        $post = new \DSteffen\Model\Entity\Post($this->testdata);
        
        $this->assertEquals($post->getId(), 4);
        $this->assertEquals($post->getTitle(), "test1");
        $this->assertEquals($post->getMessage(), "test2");
        $this->assertEquals($post->getAuthor(), "test3");
        $this->assertEquals($post->getCreatedAt(), "2010-10-10 10:10:10");
        $this->assertEquals($post->getUpdatedAt(), "2011-10-10 10:10:10");
        
        $post->setTitle("test4");
        $post->setMessage("test5");
        $post->setAuthor("test6");
        $post->setUpdatedAt("2015-10-10 10:10:10");
        
        $this->assertEquals($post->getTitle(), "test4");
        $this->assertEquals($post->getMessage(), "test5");
        $this->assertEquals($post->getAuthor(), "test6");
        $this->assertEquals($post->getUpdatedAt(), "2015-10-10 10:10:10");
    }
    
    public function testPossibleToSerializeJson() {
        $this->assertJson($this->post->serialize());   
    }
    
    public function testIsIdReadonly() {
        $this->post->setId(9);
        
        $this->assertEquals($this->post->getId(), 4);
    }
    
    public function testIsCreatedAtReadonly() {
        $this->user->setCreatedAt("2015-10-10 10:10:10");
        
        $this->assertEquals($this->post->getCreatedAt(), "2010-10-10 10:10:10");
    }
}
