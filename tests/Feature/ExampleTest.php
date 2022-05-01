<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
       
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_bitcoin_page_url(){

        $response = $this->get('/bitcoin');
        $response->assertStatus(200);
    }

    public function test_bitcoin_post_data(){
        
        $response = $this->post('/chart-json',['start_date'=>'2022-01-01','end_date'=>'2022-01-31']);
        //dd($response);
        $response->assertStatus(200);
    }
}
