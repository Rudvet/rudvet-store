<!-- AI Assistant Chat Widget -->
<div id="ai-assistant-widget" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button (Floating) -->
    <button 
        id="ai-toggle-btn"
        class="ai-toggle-btn w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 flex items-center justify-center text-white text-2xl"
        title="AI Assistant">
        💬
    </button>

    <!-- Chat Window -->
    <div 
        id="ai-chat-window"
        class="ai-chat-window hidden fixed bottom-20 right-4 w-96 max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-2xl">🤖</span>
                <div>
                    <h3 class="font-bold text-base">AI Помощник</h3>
                    <p class="text-xs text-purple-100">Помогу выбрать товар</p>
                </div>
            </div>
            <button id="ai-close-btn" class="hover:bg-white/20 p-2 rounded-lg transition">
                ✕
            </button>
        </div>

        <!-- Messages Container -->
        <div id="ai-messages" class="h-80 overflow-y-auto bg-gray-50 p-4 space-y-3">
            <div class="ai-message ai-bot-message">
                <div class="bg-purple-100 text-gray-800 rounded-lg px-4 py-2 max-w-xs">
                    <p class="text-sm">Привет! 👋 Я помогу вам найти идеальный товар. Расскажите:</p>
                    <p class="text-xs text-gray-600 mt-2">• Какой товар вас интересует?</p>
                    <p class="text-xs text-gray-600">• Ваш бюджет?</p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t bg-white p-3 space-y-2">
            <!-- Quick Suggestions -->
            <div class="flex flex-wrap gap-2 mb-2" id="ai-suggestions">
                <!-- Динамически заполнится -->
            </div>

            <!-- Input Form -->
            <form id="ai-chat-form" class="flex space-x-2">
                <input 
                    type="text"
                    id="ai-message-input"
                    placeholder="Напишите вопрос..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                    maxlength="500">
                <button 
                    type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center space-x-1 font-medium text-sm">
                    <span>Отправить</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .ai-toggle-btn {
        animation: pulse 2s infinite;
    }

    .ai-toggle-btn:hover {
        animation: none;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(147, 51, 234, 0);
        }
    }

    .ai-chat-window.show {
        transform: scale(1);
        opacity: 1;
    }

    .ai-message {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ai-bot-message .bg-purple-100 {
        border-left: 4px solid #9333ea;
    }

    .ai-user-message {
        text-align: right;
    }

    .ai-user-message .bg-purple-600 {
        color: white;
    }

    .ai-loading {
        display: flex;
        space-x: 2px;
    }

    .ai-loading span {
        height: 8px;
        width: 8px;
        margin: 0 2px;
        background-color: #9333ea;
        border-radius: 50%;
        display: inline-block;
        animation: bounce 1.4s infinite;
    }

    .ai-loading span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .ai-loading span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {
        0%, 80%, 100% {
            transform: scale(0);
        }
        40% {
            transform: scale(1);
        }
    }

    .suggestion-btn {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .suggestion-btn:hover {
        background-color: #e5e7eb;
        border-color: #9333ea;
        color: #9333ea;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('ai-toggle-btn');
    const closeBtn = document.getElementById('ai-close-btn');
    const chatWindow = document.getElementById('ai-chat-window');
    const chatForm = document.getElementById('ai-chat-form');
    const messageInput = document.getElementById('ai-message-input');
    const messagesContainer = document.getElementById('ai-messages');
    const suggestionsContainer = document.getElementById('ai-suggestions');

    // Toggle chat window
    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('show');
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            messageInput.focus();
        }
    });

    // Close chat window
    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
        chatWindow.classList.remove('show');
    });

    // Отправка сообщения
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        
        if (!message) return;

        // Добавить сообщение пользователя
        addMessage(message, 'user');
        messageInput.value = '';

        // Показать loading
        addLoadingMessage();

        try {
            const response = await fetch('/api/assistant/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();

            // Удалить loading
            removeLoadingMessage();

            if (data.success) {
                addMessage(data.assistant_message, 'bot');
                updateSuggestions(data.suggestions);
            } else {
                addMessage('Извините, произошла ошибка. Попробуйте позже.', 'bot');
            }
        } catch (error) {
            removeLoadingMessage();
            addMessage('Ошибка подключения. Проверьте интернет.', 'bot');
        }
    });

    // Добавить сообщение в чат
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `ai-message ai-${sender}-message`;

        let bgClass = sender === 'bot' ? 'bg-purple-100 text-gray-800' : 'bg-purple-600 text-white';
        let alignment = sender === 'bot' ? 'mr-12' : 'ml-12';

        messageDiv.innerHTML = `
            <div class="${bgClass} rounded-lg px-4 py-2 max-w-xs ${alignment}">
                <p class="text-sm">${escapeHtml(text)}</p>
            </div>
        `;

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Добавить loading индикатор
    function addLoadingMessage() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'ai-message ai-bot-message ai-loading-message';
        messageDiv.innerHTML = `
            <div class="ai-loading">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Удалить loading индикатор
    function removeLoadingMessage() {
        const loadingMsg = messagesContainer.querySelector('.ai-loading-message');
        if (loadingMsg) {
            loadingMsg.remove();
        }
    }

    // Обновить предложения
    function updateSuggestions(suggestions) {
        suggestionsContainer.innerHTML = '';
        
        const defaultSuggestions = [
            { label: '💰 По цене', query: 'Покажи товары в моем бюджете' },
            { label: '⭐ Топ рейтинговые', query: 'Какие товары самые популярные?' },
            { label: '🔍 Сравнить', query: 'Сравни товары для меня' }
        ];

        defaultSuggestions.forEach(suggestion => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'suggestion-btn';
            btn.textContent = suggestion.label;
            btn.addEventListener('click', () => {
                messageInput.value = suggestion.query;
                messageInput.focus();
            });
            suggestionsContainer.appendChild(btn);
        });
    }

    // Escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Инициализировать предложения
    updateSuggestions([]);

    // Закрыть окно при нажатии ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !chatWindow.classList.contains('hidden')) {
            chatWindow.classList.add('hidden');
            chatWindow.classList.remove('show');
        }
    });
});
</script>
