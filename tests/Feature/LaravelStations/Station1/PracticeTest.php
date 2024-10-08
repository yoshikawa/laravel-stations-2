<?php

namespace Tests\Feature\LaravelStations\Station1;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('station1')]
class PracticeTest extends TestCase
{
    public function testPracticeが表示されるか(): void
    {
        $response = $this->get('/practice');
        $response->assertStatus(200);
        $response->assertSeeText('practice');
    }

    public function testPractice2が表示されるか(): void
    {
        $response = $this->get('/practice2');
        $response->assertStatus(200);
        $response->assertSeeText('practice2');
    }

    public function testPractice3が表示されるか(): void
    {
        $response = $this->get('/practice3');
        $response->assertStatus(200);
        $response->assertSeeText('test');
    }
}
