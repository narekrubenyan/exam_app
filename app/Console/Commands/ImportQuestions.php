<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Statement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportQuestions extends Command
{
    protected $signature = 'import:questions {file}';
    protected $description = 'Import Armenian exam questions from .txt into the DB';

    public function handle()
    {
        $filePath = $this->argument('file');
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $categories = ['Ստոմատոլոգ', 'Օրթոպեդիկ', 'Քունքստործնոտային'];
        $currentCategory = '';
        $currentQuestion = null;
        $answers = [];
        $statements = [];
        $rightAnswer = '';

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^(Ստոմատոլոգ|Օրթոպեդիկ|Քունքստործնոտային)/u', $line)) {
                $currentCategory = $line;
                continue;
            }

            if (preg_match('/^\d+\.\s*(.*)/u', $line, $match)) {
                if ($currentQuestion) {
                    $this->saveQuestion($currentQuestion, $answers, $statements, $rightAnswer, $currentCategory);
                }

                $currentQuestion = $match[1];
                $answers = [];
                $statements = [];
                $rightAnswer = '';
                continue;
            }

            if (preg_match('/^\d+\.\s*(.*)/u', $line, $match) && $currentQuestion && !$this->isAnswerLine($line)) {
                $statements[] = $match[1];
                continue;
            }

            if (preg_match('/^[ա-ե]\)\s*(.*)/u', $line, $match)) {
                $answers[] = $match[1];
                continue;
            }

            if (preg_match('/^right answer\s*\)?\s*([ա-ե])/ui', $line, $match)) {
                $rightAnswer = $match[1];
                continue;
            }
        }

        if ($currentQuestion) {
            $this->saveQuestion($currentQuestion, $answers, $statements, $rightAnswer, $currentCategory);
        }

        $this->info("✅ Import completed successfully!");
    }

    private function saveQuestion($title, $answers, $statements, $rightAnswer, $categoryName)
    {
        DB::transaction(function () use ($title, $answers, $statements, $rightAnswer, $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            $question = Question::create([
                'title' => $title,
                'category_id' => $category->id,
            ]);

            foreach ($statements as $s) {
                Statement::create([
                    'text' => $s,
                    'question_id' => $question->id,
                ]);
            }

            $letters = ['ա', 'բ', 'գ', 'դ', 'ե'];
            foreach ($answers as $i => $text) {
                $isCorrect = ($letters[$i] === $rightAnswer) ? 1 : 0;
                Answer::create([
                    'text' => $text,
                    'is_correct' => $isCorrect,
                    'question_id' => $question->id,
                ]);
            }

            $this->info("✔️ {$category} → {$title}");
        });
    }

    private function isAnswerLine($line)
    {
        return preg_match('/^[ա-ե]\)/u', $line);
    }
}
