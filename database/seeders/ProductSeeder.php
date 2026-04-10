<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $cats = Category::pluck('id', 'slug');

        $products = [
            // Смартфоны
            ['name' => 'iPhone 17 Pro Max', 'brand' => 'Apple', 'category_id' => $cats['smartphones'], 'price' => 134990, 'old_price' => 149990, 'stock' => 15, 'image_url' => '', 'short_description' => 'Мощнейший смартфон с титановым корпусом', 'description' => 'iPhone 15 Pro Max — вершина инженерного искусства Apple. Чип A17 Pro, камера 48 МП с 5-кратным оптическим зумом, экран Super Retina XDR 6.7", титановый корпус. 256 ГБ встроенной памяти.', 'specs' => 'Процессор: A17 Pro
Экран: 6.7" OLED 2796x1290
Камера: 48 МП + 12 МП + 12 МП
Аккумулятор: 4422 мАч
Память: 256 ГБ', 'featured' => true, 'active' => true],
            ['name' => 'Samsung Galaxy S24 Ultra', 'brand' => 'Samsung', 'category_id' => $cats['smartphones'], 'price' => 119990, 'old_price' => 134990, 'stock' => 20, 'image_url' => '', 'short_description' => 'Флагман Samsung со стилусом S Pen', 'description' => 'Samsung Galaxy S24 Ultra — лучший Android-смартфон года. Snapdragon 8 Gen 3, камера 200 МП, встроенный S Pen, экран 6.8" Dynamic AMOLED 2X. Идеален для продуктивности и творчества.', 'specs' => 'Процессор: Snapdragon 8 Gen 3
Экран: 6.8" AMOLED 3088x1440
Камера: 200 МП
Аккумулятор: 5000 мАч
Память: 256 ГБ', 'featured' => true, 'active' => true],
            ['name' => 'Google Pixel 8 Pro', 'brand' => 'Google', 'category_id' => $cats['smartphones'], 'price' => 89990, 'old_price' => null, 'stock' => 12, 'image_url' => '', 'short_description' => 'Лучшие фото с ИИ от Google', 'description' => 'Google Pixel 8 Pro с чипом Tensor G3 и передовыми ИИ-функциями. Лучшая камера в своём классе, 7 лет обновлений Android.', 'specs' => 'Процессор: Google Tensor G3
Экран: 6.7" LTPO OLED
Камера: 50 МП
Аккумулятор: 5050 мАч
Память: 128 ГБ', 'featured' => false, 'active' => true],
            ['name' => 'Xiaomi 14 Ultra', 'brand' => 'Xiaomi', 'category_id' => $cats['smartphones'], 'price' => 94990, 'old_price' => 99990, 'stock' => 8, 'image_url' => '', 'short_description' => 'Камера Leica и Snapdragon 8 Gen 3', 'description' => 'Xiaomi 14 Ultra с камерой Leica и Snapdragon 8 Gen 3. Четыре камеры Leica, зарядка 90 Вт, экран LTPO AMOLED 6.73".', 'specs' => 'Процессор: Snapdragon 8 Gen 3
Экран: 6.73" LTPO AMOLED
Камера: 50 МП Leica
Аккумулятор: 5000 мАч
Память: 256 ГБ', 'featured' => true, 'active' => true],

            // Планшеты
            ['name' => 'iPad Pro 12.9" M2', 'brand' => 'Apple', 'category_id' => $cats['tablets'], 'price' => 109990, 'old_price' => 119990, 'stock' => 10, 'image_url' => '', 'short_description' => 'Профессиональный планшет с чипом M2', 'description' => 'iPad Pro с чипом M2 — мощнее большинства ноутбуков. Экран Liquid Retina XDR 12.9", поддержка Apple Pencil 2, Magic Keyboard. Идеален для дизайнеров и профессионалов.', 'specs' => 'Процессор: Apple M2
Экран: 12.9" Liquid Retina XDR
Камера: 12 МП
Аккумулятор: 10758 мАч
Память: 128 ГБ', 'featured' => true, 'active' => true],
            ['name' => 'Samsung Galaxy Tab S9+', 'brand' => 'Samsung', 'category_id' => $cats['tablets'], 'price' => 79990, 'old_price' => 89990, 'stock' => 7, 'image_url' => '', 'short_description' => 'Android-планшет премиум-класса', 'description' => 'Samsung Galaxy Tab S9+ с Snapdragon 8 Gen 2 и экраном Dynamic AMOLED 2X 12.4". S Pen в комплекте, IP68 защита.', 'specs' => 'Процессор: Snapdragon 8 Gen 2
Экран: 12.4" Dynamic AMOLED 2X
Камера: 13 МП
Аккумулятор: 10090 мАч
Память: 256 ГБ', 'featured' => false, 'active' => true],

            // Наушники
            ['name' => 'Sony WH-1000XM5', 'brand' => 'Sony', 'category_id' => $cats['headphones'], 'price' => 29990, 'old_price' => 34990, 'stock' => 25, 'image_url' => '', 'short_description' => 'Лучшее шумоподавление в мире', 'description' => 'Sony WH-1000XM5 — лучшие беспроводные наушники с шумоподавлением. 30 часов автономной работы, 8 микрофонов для кристально чистых звонков.', 'specs' => 'Тип: Накладные беспроводные
Шумоподавление: Да (активное)
Автономность: 30 часов
Подключение: Bluetooth 5.2
Вес: 250 г', 'featured' => true, 'active' => true],
            ['name' => 'Apple AirPods Pro 2', 'brand' => 'Apple', 'category_id' => $cats['headphones'], 'price' => 24990, 'old_price' => 27990, 'stock' => 30, 'image_url' => '', 'short_description' => 'ANC и Spatial Audio от Apple', 'description' => 'AirPods Pro 2 с чипом H2 — двукратно улучшенное шумоподавление. Адаптивный звук, Spatial Audio, до 6 часов автономной работы.', 'specs' => 'Тип: Вкладыши беспроводные
Шумоподавление: Да (активное)
Автономность: 6 + 24 часа с кейсом
Подключение: Bluetooth 5.3
Влагозащита: IP54', 'featured' => true, 'active' => true],
            ['name' => 'Samsung Galaxy Buds3 Pro', 'brand' => 'Samsung', 'category_id' => $cats['headphones'], 'price' => 18990, 'old_price' => 21990, 'stock' => 20, 'image_url' => '', 'short_description' => 'Беспроводные вкладыши с ANC', 'description' => 'Samsung Galaxy Buds3 Pro с интеллектуальным шумоподавлением и Hi-Fi звуком. Идеально подходят для Galaxy устройств.', 'specs' => 'Тип: Вкладыши беспроводные
Шумоподавление: Да
Автономность: 7 + 21 час
Подключение: Bluetooth 5.4
Вес: 5.5 г', 'featured' => false, 'active' => true],

            // Ноутбуки
            ['name' => 'MacBook Pro 16" M3 Pro', 'brand' => 'Apple', 'category_id' => $cats['laptops'], 'price' => 249990, 'old_price' => null, 'stock' => 5, 'image_url' => '', 'short_description' => 'Профессиональный ноутбук на чипе M3 Pro', 'description' => 'MacBook Pro 16" с чипом M3 Pro — идеальный ноутбук для профессионалов. 18 ГБ унифицированной памяти, 512 ГБ SSD, экран Liquid Retina XDR.', 'specs' => 'Процессор: Apple M3 Pro (12 ядер)
ОЗУ: 18 ГБ
Накопитель: 512 ГБ SSD
Экран: 16.2" Liquid Retina XDR
Автономность: 22 часа', 'featured' => true, 'active' => true],
            ['name' => 'ASUS ROG Zephyrus G16', 'brand' => 'ASUS', 'category_id' => $cats['laptops'], 'price' => 189990, 'old_price' => 209990, 'stock' => 4, 'image_url' => '', 'short_description' => 'Игровой ноутбук с RTX 4080', 'description' => 'ASUS ROG Zephyrus G16 — мощнейший игровой ноутбук. Intel Core Ultra 9, RTX 4080, экран OLED 240 Гц. Для самых требовательных игр.', 'specs' => 'Процессор: Intel Core Ultra 9
Видеокарта: NVIDIA RTX 4080
ОЗУ: 32 ГБ DDR5
Накопитель: 1 ТБ SSD
Экран: 16" OLED 240 Гц', 'featured' => true, 'active' => true],
            ['name' => 'Lenovo ThinkPad X1 Carbon Gen 12', 'brand' => 'Lenovo', 'category_id' => $cats['laptops'], 'price' => 149990, 'old_price' => 159990, 'stock' => 6, 'image_url' => '', 'short_description' => 'Деловой ноутбук весом 1 кг', 'description' => 'Lenovo ThinkPad X1 Carbon Gen 12 — легенда бизнес-ноутбуков. Вес всего 1 кг, Intel Core Ultra 7, 32 ГБ ОЗУ.', 'specs' => 'Процессор: Intel Core Ultra 7
ОЗУ: 32 ГБ
Накопитель: 512 ГБ SSD
Экран: 14" IPS 2.8K
Вес: 1.0 кг', 'featured' => false, 'active' => true],

            // Колонки
            ['name' => 'JBL Charge 5', 'brand' => 'JBL', 'category_id' => $cats['speakers'], 'price' => 12990, 'old_price' => 14990, 'stock' => 35, 'image_url' => '', 'short_description' => 'Мощная колонка с power bank', 'description' => 'JBL Charge 5 — портативная Bluetooth-колонка с мощным звуком и функцией зарядки устройств. IP67, 20 часов работы.', 'specs' => 'Мощность: 30 Вт
Автономность: 20 часов
Влагозащита: IP67
Подключение: Bluetooth 5.1
Пауэрбанк: 7500 мАч', 'featured' => true, 'active' => true],
            ['name' => 'Sonos Era 300', 'brand' => 'Sonos', 'category_id' => $cats['speakers'], 'price' => 44990, 'old_price' => null, 'stock' => 8, 'image_url' => '', 'short_description' => 'Пространственный звук Dolby Atmos', 'description' => 'Sonos Era 300 — первая колонка с пространственным звуком Dolby Atmos. Шесть динамиков, технология TrueSpace, Wi-Fi и Bluetooth.', 'specs' => 'Тип: Стационарная
Audio: Dolby Atmos
Динамиков: 6
Подключение: Wi-Fi + Bluetooth
Голосовые помощники: Alexa, Google', 'featured' => false, 'active' => true],

            // Аксессуары
            ['name' => 'Кабель USB-C 100W Anker', 'brand' => 'Anker', 'category_id' => $cats['accessories'], 'price' => 1990, 'old_price' => 2490, 'stock' => 100, 'image_url' => '', 'short_description' => 'Кабель 100W для быстрой зарядки', 'description' => 'Anker USB-C кабель 100W — заряжайте ноутбуки, планшеты и смартфоны. Длина 1.8 м, нейлоновая оплётка, 10 Гбит/с передача данных.', 'specs' => 'Мощность: 100 Вт
Длина: 1.8 м
Скорость данных: 10 Гбит/с
Оплётка: Нейлон
Стандарт: USB4', 'featured' => false, 'active' => true],
            ['name' => 'Зарядное устройство Anker 140W GaN', 'brand' => 'Anker', 'category_id' => $cats['accessories'], 'price' => 6990, 'old_price' => 7990, 'stock' => 45, 'image_url' => '', 'short_description' => 'GaN зарядка 140W для 3 устройств', 'description' => 'Anker 140W GaN зарядное устройство с 3 портами (2× USB-C + USB-A). Заряжайте ноутбук, планшет и смартфон одновременно.', 'specs' => 'Мощность: 140 Вт
Порты: 2× USB-C + 1× USB-A
Технология: GaN
Размер: Компактный
Сертификат: CE, RoHS', 'featured' => false, 'active' => true],
            ['name' => 'Чехол Apple MagSafe iPhone 15 Pro', 'brand' => 'Apple', 'category_id' => $cats['accessories'], 'price' => 5990, 'old_price' => null, 'stock' => 60, 'image_url' => '', 'short_description' => 'Оригинальный чехол с MagSafe', 'description' => 'Оригинальный чехол Apple для iPhone 15 Pro с поддержкой MagSafe. Изготовлен из силикона с мягкой подкладкой из микроволокна.', 'specs' => 'Материал: Силикон
Совместимость: iPhone 15 Pro
MagSafe: Да
Цвет: Тёмная ночь
Гарантия: 1 год', 'featured' => false, 'active' => true],
            ['name' => 'Беспроводная зарядка Belkin 15W', 'brand' => 'Belkin', 'category_id' => $cats['accessories'], 'price' => 3490, 'old_price' => 4290, 'stock' => 40, 'image_url' => '', 'short_description' => 'Быстрая беспроводная зарядка 15W', 'description' => 'Belkin BoostCharge беспроводная зарядка 15W. Совместима с MagSafe устройствами, зарядка через чехол до 3 мм.', 'specs' => 'Мощность: 15 Вт
Технология: Qi2
Совместимость: iPhone, Samsung, другие Qi
Диаметр: 10 см
Кабель: USB-C в комплекте', 'featured' => false, 'active' => true],
        ];

        foreach ($products as $p) {
            $p['slug'] = \Illuminate\Support\Str::slug($p['name']) . '-' . rand(1000, 9999);
            Product::create($p);
        }
    }
}