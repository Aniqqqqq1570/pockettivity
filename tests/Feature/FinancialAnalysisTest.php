<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\FinancialAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenAI\Resources\Chat;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Testing\ClientFake;
use RuntimeException;
use Tests\TestCase;

class FinancialAnalysisTest extends TestCase
{
    use RefreshDatabase;

    public function test_analysis_redirects_guests_to_login(): void
    {
        $this->get(route('analysis'))
            ->assertRedirect(route('login'));
    }

    public function test_analysis_only_displays_the_authenticated_users_financial_data(): void
    {
        $this->freezeTime();

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = $user->categories()->create(['name' => 'Belanja pribadi']);
        $otherCategory = $otherUser->categories()->create(['name' => 'Kategori rahasia']);

        $user->transactions()->create([
            'category_id' => $category->id,
            'type' => 'pemasukan',
            'amount' => 800000,
            'description' => 'Pemasukan milik saya',
            'date' => now()->toDateString(),
        ]);

        $user->transactions()->create([
            'category_id' => $category->id,
            'type' => 'pengeluaran',
            'amount' => 125000,
            'description' => 'Transaksi milik saya',
            'date' => now()->toDateString(),
        ]);

        $otherUser->transactions()->create([
            'category_id' => $otherCategory->id,
            'type' => 'pengeluaran',
            'amount' => 987654,
            'description' => 'Transaksi milik pengguna lain',
            'date' => now()->toDateString(),
        ]);

        $user->budgets()->create([
            'category_id' => $category->id,
            'amount' => 500000,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $otherUser->budgets()->create([
            'category_id' => $otherCategory->id,
            'amount' => 9000000,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        $response = $this->actingAs($user)->get(route('analysis', ['user_id' => $otherUser->id]));

        $response->assertOk()
            ->assertSee('Transaksi milik saya')
            ->assertSee('Belanja pribadi')
            ->assertSee('500.000')
            ->assertSee('375.000')
            ->assertSee('800.000')
            ->assertSee('125.000')
            ->assertDontSee('Transaksi milik pengguna lain')
            ->assertDontSee('Kategori rahasia')
            ->assertDontSee('9.000.000');
    }

    public function test_analysis_generation_shows_a_friendly_message_when_openai_is_not_configured(): void
    {
        config(['services.openai.api_key' => null]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('analysis.generate'));

        $response->assertRedirect(route('analysis'))
            ->assertSessionHas('ai_error', 'Analisis AI belum tersedia. Tambahkan OPENAI_API_KEY pada konfigurasi aplikasi.');
    }

    public function test_analysis_generation_displays_advice_returned_by_openai(): void
    {
        config(['services.openai.api_key' => 'test-key']);
        $user = User::factory()->create();
        $category = $user->categories()->create(['name' => 'Belanja pribadi']);
        $user->transactions()->create([
            'category_id' => $category->id,
            'type' => 'pengeluaran',
            'amount' => 125000,
            'description' => 'PRIVATE_TRANSACTION_DESCRIPTION',
            'date' => now()->toDateString(),
        ]);
        $fakeClient = new ClientFake([
            CreateResponse::fake([
                'choices' => [[
                    'message' => [
                        'role' => 'assistant',
                        'content' => 'Pengeluaran bulan ini masih sesuai dengan budget.',
                    ],
                ]],
            ]),
        ]);
        $this->app->instance(FinancialAnalysisService::class, new FinancialAnalysisService($fakeClient));

        $response = $this->actingAs($user)->post(route('analysis.generate'));

        $response->assertRedirect(route('analysis'))
            ->assertSessionHas('ai_analysis', 'Pengeluaran bulan ini masih sesuai dengan budget.');
        $this->get(route('analysis'))
            ->assertOk()
            ->assertSee('Pengeluaran bulan ini masih sesuai dengan budget.');

        $fakeClient->assertSent(Chat::class, function (string $method, array $parameters): bool {
            $this->assertSame('create', $method);
            $this->assertStringNotContainsString(
                'PRIVATE_TRANSACTION_DESCRIPTION',
                json_encode($parameters, JSON_THROW_ON_ERROR),
            );

            return true;
        });
    }

    public function test_analysis_generation_hides_openai_error_details(): void
    {
        config(['services.openai.api_key' => 'test-key']);
        $user = User::factory()->create();
        $fakeClient = new ClientFake([new RuntimeException('secret provider response')]);
        $this->app->instance(FinancialAnalysisService::class, new FinancialAnalysisService($fakeClient));

        $response = $this->actingAs($user)->post(route('analysis.generate'));

        $response->assertRedirect(route('analysis'))
            ->assertSessionHas('ai_error', 'Analisis AI sedang mengalami kendala. Coba lagi beberapa saat lagi.');

        $this->get(route('analysis'))
            ->assertOk()
            ->assertSee('AI analysis could not be generated right now.')
            ->assertDontSee('secret provider response');
    }
}
