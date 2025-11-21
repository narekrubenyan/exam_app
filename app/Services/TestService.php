<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Option;
use App\Models\Category;
use App\Models\Question;
use App\Models\TestQuestions;
use Illuminate\Support\Facades\DB;

/**
 * Class TestService.
 */
class TestService
{
    public function createOrUpdate($data)
    {
        DB::beginTransaction();

        try {
            $categoryIds = $data['categories'];   // массив категорий
            $requiredTotal = $data['count'];      // например 20

            $categories = Category::whereIn('id', $categoryIds)->get();
            $options = Option::all();

            // Проверка, что вопросов достаточно
            $totalAvailable = Question::whereIn('category_id', $categoryIds)->count();

            if ($totalAvailable < $requiredTotal) {
                DB::rollBack();
                return back()
                    ->withErrors(['name' => 'Недостаточно вопросов в выбранных категориях'])
                    ->withInput();
            }

            // Равномерное распределение количества
            $categoryCount = count($categoryIds);

            $perCategory = intdiv($requiredTotal, $categoryCount);
            $remainder = $requiredTotal % $categoryCount;

            // Сколько вопросов брать из каждой категории
            $distribution = [];

            foreach ($categoryIds as $catId) {
                $distribution[$catId] = $perCategory;

                if ($remainder > 0) {
                    $distribution[$catId]++;
                    $remainder--;
                }
            }

            // Для каждого варианта — создаём или обновляем тест
            foreach ($options as $option) {

                $selectedQuestions = collect();

                foreach ($distribution as $catId => $count) {
                    $questions = Question::where('category_id', $catId)
                        ->inRandomOrder()
                        ->take($count)
                        ->get();

                    $selectedQuestions = $selectedQuestions->merge($questions);
                }

                $selectedIds = $selectedQuestions->pluck('id')->unique();

                if ($selectedIds->count() < $requiredTotal) {
                    DB::rollBack();
                    throw new \Exception("Недостаточно вопросов для варианта {$option->id}");
                }

                // Ищем тест по варианту (category_id больше нет)
                $test = Test::where('option_id', $option->id)->first();

                if (!$test) {
                    $test = Test::create([
                        'option_id' => $option->id,
                    ]);
                }

                // Записываем вопросы
                $test->questions()->sync($selectedIds);
            }

            DB::commit();
            return redirect()->route('tests.index')->with('success', 'Варианты успешно созданы');

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
