<?php

namespace Tests\Feature\LaravelStations\Station1;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class PracticeTest extends TestCase
{
    #[Test]
    #[Group('station1')]
    public function testPracticeが表示されるか(): void
    {
        $response = $this->get('/practice');
        $response->assertStatus(200);
        $response->assertSeeText('practice');
    }

    #[Test]
    #[Group('station1')]
    public function testPractice2が表示されるか(): void
    {
        $response = $this->get('/practice2');
        $response->assertStatus(200);
        $response->assertSeeText('practice2');
    }

    #[Test]
    #[Group('station1')]
    public function testPractice3が表示されるか(): void
    {
        $response = $this->get('/practice3');
        $response->assertStatus(200);
        $response->assertSeeText('test');
    }
}
