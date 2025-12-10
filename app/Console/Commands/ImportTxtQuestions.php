<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\Statement;
use App\Models\Answer;
use App\Models\Subcategory;

class ImportTxtQuestions extends Command
{
    protected $signature = 'import:questions';
    protected $description = 'Import exam questions from .txt files into the database';

    public function handle()
    {
        $folder = storage_path('questions');
        $files = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'txt') {
                $files[] = $file->getPathname();
            }
        }

        if (empty($files)) {
            $this->warn('No .txt files found in ' . $folder);
            return;
        }

        $currentSubcategory = null;

        foreach ($files as $file) {

            $lines = array_values(array_filter(array_map('trim', file($file))));
            if (empty($lines)) continue;

            $this->info("📄 Processing file: " . basename($file));

            $question = null;
            $answers = [];

            $i = 0;

            while ($i < count($lines)) {

                $line = $lines[$i];

                /*
                |--------------------------------------------------------------------------
                | 1) SUBCATEGORY LINE  →  "Name (1)"
                |--------------------------------------------------------------------------
                */
                if (preg_match('/^(.+)\((\d+)\)$/u', $line, $m) && !preg_match('/^\d/', $line)) {

                    $subcategoryName = trim($m[1]);
                    $categoryId      = intval($m[2]);

                    $currentSubcategory = Subcategory::firstOrCreate(
                        [
                            'name' => $subcategoryName,
                            'category_id' => $categoryId,
                        ],
                        [
                            'slug' => Str::slug($subcategoryName),
                            'description' => null,
                        ]
                    );

                    $this->info("➡ Subcategory: {$subcategoryName}");

                    $i++;
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | 2) QUESTION LINE  → "58. Something something"
                |    Must be ONLY the question, NOT statements
                |--------------------------------------------------------------------------
                */
                if (preg_match('/^\d+[\.\)]\s+(.+)/u', $line, $qMatch)) {

                    // THIS IS QUESTION ONLY IF:
                    // Next line is NOT answer option
                    // Next line IS NOT right answer
                    // Next line is statement or answer or anything else

                    $next = $lines[$i + 1] ?? '';

                    if ($question === null) {
                        $question = Question::create([
                            'title' => trim($qMatch[1]),
                            'subcategory_id' => $currentSubcategory->id ?? null,
                        ]);

                        $answers = [];

                        $i++;
                        continue;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | 3) STATEMENT LINE  → "1. something", "2. something"
                |    Only if question already exists AND next line is NOT Armenian letter
                |--------------------------------------------------------------------------
                */
                if (
                    $question &&
                    preg_match('/^\d+\.\s*(.+)/u', $line, $sMatch) &&
                    !preg_match('/^[ա-ֆ]\)/u', $line) // not answer line
                ) {
                    Statement::create([
                        'text' => trim($sMatch[1]),
                        'question_id' => $question->id,
                    ]);

                    $i++;
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | 4) ANSWER OPTION  → "ա) text"
                |--------------------------------------------------------------------------
                */
                if ($question && preg_match('/^([ա-ֆ])\)\s*(.+)/u', $line, $aMatch)) {

                    $key = $aMatch[1];

                    $answers[$key] = Answer::create([
                        'text' => trim($aMatch[2]),
                        'question_id' => $question->id,
                        'is_correct' => false,
                    ]);

                    $i++;
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | 5) RIGHT ANSWER  → "right answer գ)"
                |--------------------------------------------------------------------------
                */
                if ($question && preg_match('/right answer\s*([ա-ֆ])\)/iu', $line, $rMatch)) {

                    $correctKey = $rMatch[1];

                    if (isset($answers[$correctKey])) {
                        $answers[$correctKey]->update(['is_correct' => true]);
                    } else {
                        $this->error("⚠ Correct answer '{$correctKey}' not found for question '{$question->title}'");
                    }

                    $this->info("✅ Imported: {$question->title}");

                    $question = null;
                    $answers = [];

                    $i++;
                    continue;
                }

                $i++;
            }
        }

        $this->info("✨ All .txt files imported successfully!");
    }
}
