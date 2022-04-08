<?php

namespace Tests\Unit;

use Tests\TestCase;

class NewsCategoriesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('api/newscategory');
        $response->assertStatus(200);
    }
}
