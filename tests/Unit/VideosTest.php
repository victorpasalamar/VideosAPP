<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Video; // Importem el model Video

class VideosTest extends TestCase
{
use RefreshDatabase;
/**
* Comprovar que es pot obtenir la data formatada correctament.
 * @return void
*/
    #[Test] public function can_get_formatted_published_at_date()
    {
        $video = Video::factory()->create([
            'published_at' => Carbon::create(2025, 1, 13, 10, 0, 0),
        ]);

        $formattedDate = $video->formattedPublishedAt; // Format "13 de gener de 2025"
        $this->assertEquals('13 de gener de 2025', $formattedDate);

        $formattedForHumans = $video->formattedForHumansPublishedAt; // Format "fa 2 hores"
        $this->assertStringContainsString('fa', $formattedForHumans); // Per exemple, "fa 2 hores"

    }

    #[Test] public function can_get_formatted_published_at_date_for_humans()
    {
        $video = Video::factory()->make([
            'published_at' => now()->subHours(2),
        ]);

        $this->assertEquals('fa 2 hores', $video->formatted_for_humans_published_at);
    }

    #[Test] public function can_get_published_at_timestamp()
    {
        $publishedAt = Carbon::create(2025, 1, 13, 12, 0, 0);
        $video = Video::factory()->make([
            'published_at' => $publishedAt,
        ]);

        $this->assertEquals($publishedAt->timestamp, $video->published_at_timestamp);

    }
}
