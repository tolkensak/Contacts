# Contacts

Технологический стек:
    - PHP 8.2
    - MySQL 8.0.33
    - Javascript >ES6
    - SASS/SCSS

</br>

## 1. Техническое задание (ТЗ)

</br>

### 1.1. Работа с пользователем

1. Создание системы регистрации пользователя в проекте (кол-во информации о пользователе не важно)

2. Создание системы авторизации пользователя в проекте

3. Создание закрытой части проекта, доступной только после авторизации

4. Незарегистрированным пользователям доступна только страница регистрации/ авторизации.

</br>

### 1.2. Создание контактов в системе (общие и личные)

1. Необходимо придумать и разместить на главной странице проекта произвольный «общий список контактов», который будет доступен каждому авторизованному пользователю в системе. (достаточно заполнить 10-15 произвольных контактов)

2. Добавить возможность сохранения в личные контакты пользователя контактов из общего списка (раздел избранное)

</br>

### 1.3. Результатом выполнения всех частей ТЗ должны стать

1. Система авторизации / регистрации пользователя и страница авторизации (регистрации)

2. Главная страница с общим списком контактов (10-15 контактов) - должна отображаться одинаково для всех авторизованных пользователей

3. Раздел избранных контактов пользователя - должен быть разным для каждого авторизованного пользователя.

</br>

## 2. Выполненный проект

</br>

### 2.1. Работа с пользователем

1. СДЕЛАНО: Создание системы регистрации пользователя в проекте (кол-во информации о пользователе не важно)

![signup](/screenshot/signup.jpg)

2. СДЕЛАНО: Создание системы авторизации пользователя в проекте

![signin](/screenshot/signin.jpg)

3. СДЕЛАНО: Создание закрытой части проекта, доступной только после авторизации

![closed](/screenshot/closed.jpg)

4. СДЕЛАНО: Незарегистрированным пользователям доступна только страница регистрации/ авторизации.

![permit](/screenshot/permit.jpg)

</br>

### 2.2. Создание контактов в системе (общие и личные)

1. СДЕЛАНО: Необходимо придумать и разместить на главной странице проекта произвольный «общий список контактов», который будет доступен каждому авторизованному пользователю в системе. (достаточно заполнить 10-15 произвольных контактов)

![all_contacts](/screenshot/all_contacts.jpg)

2. СДЕЛАНО: Добавить возможность сохранения в личные контакты пользователя контактов из общего списка (раздел избранное)

![fav_contacts](/screenshot/fav_contacts.jpg)

</br>

### 2.3. Дополнительная информация

1. База данных

    - Сервер БД: сервер MySQL 8.0.33

    - Дамп БД: [contacts.sql](/contacts.sql)

    - Данные подключения MySQL: [include/contacts.php](/include/contacts.php)

2. AJAX используется для сохранения выбранных контактов в базе данных

![fav_contacts](/screenshot/ajax_fav_update.jpg)

3. Валидация данных

![fav_contacts](/screenshot/validation_required_field_2.jpg)

![fav_contacts](/screenshot/validation_required_field_1.jpg)

![fav_contacts](/screenshot/validation_incorrect_data.jpg)

![fav_contacts](/screenshot/validation_pass_not_match.jpg)

![fav_contacts](/screenshot/validation_already_exists.jpg)
