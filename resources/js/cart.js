
document.addEventListener('DOMContentLoaded', function() {
    window.addToCart = function(productId) {
        const button = event.currentTarget;
        const originalText = button.innerHTML;
        
        button.innerHTML = '⏳ Добавление...';
        button.disabled = true;
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                product_id: productId,
                quantity: 1 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✓ Товар добавлен в корзину!', 'success');
                updateCartCount(data.count);
                
                button.innerHTML = '✓ Добавлено!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 1500);
            } else {
                throw new Error(data.message || 'Ошибка добавления');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('✗ Ошибка при добавлении товара', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    };
    
    function showNotification(message, type) {
        const oldNotifications = document.querySelectorAll('.notification-toast');
        oldNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' 
                ? 'bg-green-500' 
                : 'bg-red-500'
        } text-white font-semibold`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 10);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    window.updateCartCount = function(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => {
            el.textContent = count;
            if (count > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }
    
    fetch('/cart/count', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.count !== undefined) {
            window.updateCartCount(data.count);
        }
    })
    .catch(error => console.error('Error loading cart count:', error));
});