<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Question;
use App\Models\Statement;
use Illuminate\Console\Command;

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

        $currentSubcategory = null;

        if (empty($files)) {
            $this->warn('No .txt files found in ' . $folder);
            return;
        }

        $currentSubcategory = null;

        if (empty($files)) {
            $this->warn('No .txt files found in storage/questions/');
            return;
        }

        foreach ($files as $file) {
            $lines = array_values(array_filter(array_map('trim', file($file))));
            if (empty($lines)) continue;

            $this->info("Processing file: " . basename($file));

            $firstLine = $lines[0];
            if (!preg_match('/^\d/', $firstLine)) {
                $subcategoryName = $firstLine;
                $currentSubcategory = Subcategory::firstOrCreate(['name' => $subcategoryName]);
                unset($lines[0]);
                $lines = array_values($lines);
            }

            if (!isset($lines[0]) || !preg_match('/^\d+[\.\)]\s*(.+)/u', $lines[0], $qMatch)) {
                $this->error("❌ Could not find question line in " . basename($file));
                continue;
            }

            $questionTitle = trim($qMatch[1]);
            $question = Question::create([
                'title' => $questionTitle,
                'subcategory_id' => $currentSubcategory ? $currentSubcategory->id : null,
            ]);
            unset($lines[0]);
            $lines = array_values($lines);

            while (isset($lines[0]) && preg_match('/^\d+[\.\)]\s*(.+)/u', $lines[0], $sMatch)) {
                Statement::create([
                    'text' => trim($sMatch[1]),
                    'question_id' => $question->id,
                ]);
                unset($lines[0]);
                $lines = array_values($lines);
            }

            $answers = [];
            while (isset($lines[0]) && preg_match('/^([ա-ե])\)\s*(.+)/u', $lines[0], $aMatch)) {
                $answers[$aMatch[1]] = Answer::create([
                    'text' => trim($aMatch[2]),
                    'question_id' => $question->id,
                    'is_correct' => false,
                ]);
                unset($lines[0]);
                $lines = array_values($lines);
            }

            if (isset($lines[0]) && preg_match('/right answer\s*([ա-ե])\)/u', $lines[0], $rMatch)) {
                $correctKey = $rMatch[1];
                if (isset($answers[$correctKey])) {
                    $answers[$correctKey]->update(['is_correct' => true]);
                }
            }

            $this->info("✅ Imported question: {$question->title}");
        }

        $this->info("✨ All .txt files imported successfully!");
    }
}
