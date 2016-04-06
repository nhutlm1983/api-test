<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel 5');
    }
	
	public function testGet()
	{
		$response = $this->call('GET', '/posts');
		$this->assertEquals(200, $response->status());
	}
	
	public function testCreate()
	{
		$this->json('POST', '/posts', ['title' => 'Are you ready to win? ' . date('Y-m-d H:i:s'), 'body'=>'Are you ok?'])
			->seeJsonEquals([
				'created' => true,
			]);
	}
	
	public function testUpdate()
	{
		$this->json('PUT', '/posts/6', ['title' => "Update time " . date('Y-m-d H:i:s')])
			->seeJsonEquals([
				'updated' => true,
			]);
	}
	
	public function testGetbyid()
	{
		$response = $this->call('GET', '/posts/6');
		$this->assertEquals(200, $response->status());
	}
	
	
	
	
}
