<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $chatId = $request->input('chat_id', session()->getId()); // ID для хранения истории
        
        // история из кэша (последние 10 сообщений)
        $historyKey = "chat_history_{$chatId}";
        $history = Cache::get($historyKey, []);
        
        $history[] = [
            "role" => "user",
            "content" => $userMessage
        ];
        
        //ограничение историй последними 10 сообщениями
        $history = array_slice($history, -10);
        
        // системный промпт 
        $systemPrompt = "Ты — консультант магазина техники. Отвечай максимально коротко и по делу.
Правила:
- Максимум 4 предложения в ответе.
- Не перечисляй характеристики списком пиши в строку.
- Если спрашивают цену вежливо скажи чтоб пользователь посмотрел актуальную цену на товар на сайте
- Для улучшения пользовательского экспириенса добавь эмодзи по необходимости
- если пользователь спрашивает что то не по теме техники, электронники и прочего, попытайся вежливо грамотно уйти от вопроса
- ВАЖНО: Помни всю историю переписки. Если пользователь уточняет вопрос — учитывай предыдущие сообщения.";
        
        // 🚀 5. Отправляем запрос в Mistral С ИСТОРИЕЙ
        $messages = array_merge(
            [["role" => "system", "content" => $systemPrompt]],
            $history 
        );
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.mistral.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            "model" => "mistral-small",
            "max_tokens" => 150,
            "temperature" => 0.3,
            "messages" => $messages
        ]);
        
        $reply = $response['choices'][0]['message']['content'] ?? 'Ошибка ответа';
        
        $history[] = [
            "role" => "assistant",
            "content" => $reply
        ];
        Cache::put($historyKey, $history, now()->addHours(24)); // храним 24 часа
        
        // очистка ответа
        $reply = preg_replace('/\*\*|__|\*|_|`/', '', $reply);
        $reply = str_replace(["\n\n", "\r\n\r\n"], "\n", $reply);
        
        return response()->json([
            'reply' => $reply
        ]);
    }
}