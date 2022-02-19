<div align="center">
  <img width="200" height="200" src="https://upload.wikimedia.org/wikipedia/commons/7/72/Gulp.js_Logo.svg">
  <h1>Gulp WP starter template</h1>
  <p>
    Компиляция HTML, SCSS, JS, вывод обычных и минифицированых файлов, CSS префиксы, сжатие/конвертация картинок в webp, для img генеруруется обертка picture, вывод webp, конвертация шрифтов в WOFF, WOFF2, быстрая выгрузка на FTP сервер, собрать в ZIP архив, вывод ошибок, локальный сервер и прочее
  </p>
</div>


## Настройка сборки:

``` bash
# Установить зависимости:
npm i

# Запустить сборщик (http://localhost:3000/)
npm run dev

# Собрать проект (в папку build/) 
npm run build

# Собрать проект в ZIP архив
npm run deployZIP

# Выгрузить на FTP (gulp/config/ftp.js прописать доступы)
npm run deployFTP 

# Собрать svg иконки в спрайт, генерируется html файл с примерами
npm run svgSprive

```

## Структура сборки:
Development
* `dev/index.html` - Главный HTML файл
* `dev/html/` - HTML компоненты
* `dev/styles/` - CSS/SCSS библиотеки, компоненты, переменные, миксины, шрифты, стили модулей, стили страниц
* `dev/img` - Изображения
* `dev/js` - Библиотеки и скрипты
* `dev/fonts` - Шрифты

Production
* `build/index.html` - Главный HTML файл 
* `build/styles` - CSS стили
* `build/img` - Изображения
* `build/js` - Скрипты
* `build/fonts` - Шрифты

Wordpress

* `functions.php` - Подключение файлов functions-parts/, настройка темы, дополнительные функции, изменение параметров
* `functions-parts/ajax/` - Файлы с ajax подключаемые в _ajax.php
* `functions-parts/super-filter/` - Функции для фильтра
* `functions-parts/_ajax.php` - Основной файл с ajax запросами
* `functions-parts/_assets.php` - Подключение стилей и скриптов
* `functions-parts/_breadcrumbs.php` - Хлебные крошки
* `functions-parts/_custom-functions.php` - Вспомагальные функции
* `functions-parts/_hooks.php` - Хуки
* `functions-parts/_post-types-registration.php` - Регистрация пост тайпов
* `functions-parts/_taxonomies-registration.php` - Регистрация таксономий
* `functions-parts/Mobile_Detect.php` - Определеение типа устройств

<div align="center">
  <h2>Импорт</h2>
</div>

## HTML компоненты:

``` js
// Подключить компонент, передать значение
@@include('html/head.html',{
"title":"Главная"
})

//Получить значение
@@title
```

## CSS/SCSS файлы:
``` scss
// Подключить файл
@import "libs/swiper.min";

```

## JS файлы:
``` js
// Подключить файл, выполнить функцию
import * as functions from "./modules/functions.js";
functions.isWebp();

// Подключить библиотеку
import Swiper, { Navigation, Pagination } from 'swiper';
const swiper = new Swiper();
```