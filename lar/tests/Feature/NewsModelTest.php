<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\News;

class NewsModelTest extends TestCase
{
    public function testSlug() 
    {
        $new = new News();
        $for_slug = 'крокодил страшный';
        $slug = 'krokodil-strashnyiy';
        $this->assertEquals($slug, $new->getSlug($for_slug));
    }

    public function testPublic()
    {
        $new = new News();
        $new->public = null;
        $this->assertEquals(0, $new->public);
        $new->public = 'true';
        $this->assertEquals(1, $new->public);
        $new->public = 'false';
        $this->assertEquals(0, $new->public);
        $new->public = true;
        $this->assertEquals(1, $new->public);
        $new->public = false;
        $this->assertEquals(0, $new->public);
    }
}
