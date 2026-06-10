<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;


class RecruitmentController extends Controller
{
    public function processCV(Request $request)
    {
        $request->validate([
            'position' => 'required|string',
            'cvs' => 'required|array|max:5',
            'cvs.*' => 'mimes:pdf|max:2048'
        ]);

        $parser = new Parser();
        $allCvsText = '';

        foreach ($request->file('cvs') as $index => $file) {

            try {

                $pdf = $parser->parseFile($file->getPathname());

                $text = $pdf->getText();
                $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
                $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
                $text = substr($text, 0, 1500);

                $allCvsText .= "\n--- Kandidat ".($index + 1)." ---\n".$text;

            } catch (\Exception $e) {

                Log::warning(
                    'PDF gagal dibaca: '.$file->getClientOriginalName()
                );

                continue;
            }
        }

        if (empty(trim($allCvsText))) {

            return back()->withErrors([
                'ai' => 'Seluruh CV gagal dibaca atau tidak memiliki isi teks.'
            ]);
        }

        $prompt = "

        Posisi:
        {$request->position}

        Data Kandidat:
        {$allCvsText}

        Tugas:

        1. Analisis seluruh kandidat.
        2. Berikan penilaian:

        - Pengalaman kerja (0-40)
        - Pendidikan dan IPK (0-20)
        - Skill/Kompetensi (0-20)
        - Relevansi posisi (0-20)

        3. Hitung total score:
        score = experience_score + education_score + skill_score + relevance_score

        4. Urutkan seluruh kandidat berdasarkan score tertinggi.
        5. Tampilkan SEMUA kandidat yang diunggah.
        6. Berikan status:

        - Recommended (Top 3 kandidat dengan score tertinggi)
        - Low Match (score 40-69)
        - Not Recommended (score < 40)

        Output JSON:

        [
            {
                \"name\":\"Nama Kandidat\",
                \"score\":95,
                \"experience_score\":38,
                \"education_score\":18,
                \"skill_score\":19,
                \"relevance_score\":20,
                \"ipk\":\"3.80\",
                \"status\":\"Recommended\",
                \"insight\":\"Alasan\"
            }
        ]

        Jangan tampilkan teks selain JSON.
        ";

        try {

            Log::info('Prompt Length: '.strlen($prompt));

            $models = [
                // 'models/gemini-2.5-flash',
                // 'models/gemini-2.0-flash',
                // 'models/gemini-2.0-flash-lite'
                'models/gemini-flash-latest',
                'models/gemini-flash-lite-latest'
            ];

            $result = null;

            foreach ($models as $model) {

                try {

                    Log::info('Trying Model: '.$model);

                    $result = Gemini::generativeModel($model)
                        ->generateContent($prompt);

                    Log::info('Success Model: '.$model);

                    break;

                } catch (\Exception $e) {

                    Log::warning(
                        'Model Failed: '.$model.' | '.$e->getMessage()
                    );

                    $message = strtolower($e->getMessage());

                    if (
                        str_contains($message, 'quota exceeded') ||
                        str_contains($message, 'rate limit')
                    ) {

                        continue;
                    }

                    continue;
                }
            }

            if (!$result) {
                // throw new \Exception(
                //     'Semua model AI gagal digunakan.'
                // );
                return back()->withErrors([
                    'ai' => 'Seluruh model AI sedang tidak tersedia atau mencapai batas penggunaan. Silakan coba kembali beberapa saat lagi.'
                ]);
            }

            $rawText = $result->text();

            Log::info('Raw AI Response: '.$rawText);

            $start = strpos($rawText, '[');
            $end = strrpos($rawText, ']');

            if ($start === false || $end === false) {

                throw new \Exception(
                    'Format respon AI tidak valid.'
                );
            }

            $cleanJson = substr(
                $rawText,
                $start,
                ($end - $start + 1)
            );

            $data = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {

                throw new \Exception(
                    'JSON Malformed'
                );
            }

            foreach ($data as &$candidate) {

                $experience = (int)($candidate['experience_score'] ?? 0);
                $education = (int)($candidate['education_score'] ?? 0);
                $skill = (int)($candidate['skill_score'] ?? 0);
                $relevance = (int)($candidate['relevance_score'] ?? 0);

                $candidate['score'] =
                    $experience +
                    $education +
                    $skill +
                    $relevance;

                $candidate['score'] = max(
                    0,
                    min(100, $candidate['score'])
                );
            }

            unset($candidate);

            usort($data, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            foreach ($data as $index => &$candidate) {

                if ($index < 3) {

                    $candidate['status'] = 'Recommended';

                } elseif ($candidate['score'] >= 40) {

                    $candidate['status'] = 'Low Match';

                } else {

                    $candidate['status'] = 'Not Recommended';
                }
            }

            unset($candidate);

            return back()->with(
                'ai_results',
                $data
            );

        } catch (\Exception $e) {

            Log::error(
                'AI Analysis Error: '.$e->getMessage()
            );

            $message = strtolower($e->getMessage());

            if (str_contains($message, 'quota')) {

                return back()->withErrors([
                    'ai' => 'Kuota AI habis. Silakan coba beberapa menit lagi.'
                ]);
            }

            if (str_contains($message, 'high demand')) {

                return back()->withErrors([
                    'ai' => 'Layanan AI sedang sibuk. Silakan coba kembali.'
                ]);
            }

            return back()->withErrors([
                'ai' => 'Terjadi kesalahan saat memproses CV.'
            ]);
        }
    }
}