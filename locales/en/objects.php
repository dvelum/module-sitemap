<?php return array (
  'dvelum_article' => 
  array (
    'title' => 'Статьи',
    'fields' => 
    array (
      'text' => 'Текст',
      'title' => 'Заголовок',
      'brief' => 'Краткое содержание',
      'allow_comments' => 'Разрешить коментарии',
      'meta_keywords' => 'META KEYWORDS',
      'meta_description' => 'META DESCRIPTION',
      'image' => 'Изображение',
      'main_category' => 'Категория статьи',
      'related_category' => 'Дополнительные категории',
      'tags' => 'Теги',
      'url' => 'URL код страницы',
    ),
  ),
  'dvelum_article_related_category_to_dvelum_article_category' => 
  array (
    'title' => 'Многие ко многим (таблица связей) dvelum_article & dvelum_article_category',
    'fields' => 
    array (
      'source_id' => 'SOURCE',
      'target_id' => 'TARGET',
      'order_no' => 'SORT',
    ),
  ),
  'dvelum_article_category' => 
  array (
    'title' => 'Категория статьи',
    'fields' => 
    array (
      'title' => 'Название',
      'meta_keywords' => 'META KEYWORDS',
      'meta_description' => 'META DESCRIPTION',
      'url' => 'URL код страницы категории',
    ),
  ),
); 