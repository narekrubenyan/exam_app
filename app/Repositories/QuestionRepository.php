<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Statement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class QuestionRepository
{
    public function create($data)
    {
        DB::beginTransaction();

        try {
            $question = Question::create([
                'title' => $data['title'],
                'category_id' => $data['category_id']
            ]);

            foreach ($data['answers'] as $answerData) {
                $answer = new Answer;
                $answer->text = $answerData['text'];

                if (isset($answerData['isTrue']) && $answerData['isTrue'] == 'on') {
                    $answer->is_correct = 1;
                }

                $answer->question_id = $question->id;
                $answer->save();
            }

            foreach ($data['statements'] as $statemetText) {
                if ($statemetText) {
                    $statement = Statement::create([
                        'text' => $statemetText,
                        'question_id' => $question->id
                    ]);
                }
            }

            DB::commit();

            return $question;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
        
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function update($question, $data)
    {
        DB::beginTransaction();

        try {
            $question->update([
                'title' => $data['title'],
                'category_id' => $data['category_id']
            ]);

            Answer::where('question_id', $question->id)->delete();
            foreach ($data['answers'] as $answerData) {
                $answer = new Answer;
                $answer->text = $answerData['text'];

                if (isset($answerData['isTrue']) && $answerData['isTrue'] == 'on') {
                    $answer->is_correct = 1;
                }

                $answer->question_id = $question->id;
                $answer->save();
            }

            Statement::where('question_id', $question->id)->delete();
            foreach ($data['statements'] as $statemetText) {
                if ($statemetText) {
                    $statement = Statement::create([
                        'text' => $statemetText,
                        'question_id' => $question->id
                    ]);
                }
            }

            DB::commit();

            return $question;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
        
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            Question::find($id)->delete();
            Answer::where('question_id', $id)->delete();
            Statement::where('question_id', $id)->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
        
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

    }
}
