REST API

GET (Фильмы)
  1. Получение всех фильмов в базе - api.films/films
  2. Получение фильма по id - api.films/films/id-1
  3. Получение фильмов по определнному жанру по его id - api.films/films/genre-1
  4. Получение фильмов по определнному актеру по его id - api.films/films/actor-1
  5. Получение фильмов по определнному жанру и актеру по их id - api.films/films/genre-2/actor-4
  6. Получение отсортированных фильмов по жанру api.films/films/genre
  7. Получение отсортированных фильмов по количетсву актеров api.films/films/actor
  
GET (Актеры)
  1. Получение всех актеров в базе - api.films/actors
  2. Получение актера по id - api.films/actors/id-1
 
GET (Жанры)
  1. Получение всех жанров в базе - api.films/genres
  2. Получение жанра по id - api.films/genres/id-1
  
POST (Фильмы)
  1. Добавление идет через formdata - api.films/films (нужно ввести film и id_genre)
  
POST (Актеры)
  1. Добавление идет через formdata - api.films/actors (нужно ввести actor)

POST (Жанры)
  1. Добавление идет через formdata - api.films/genres (нужно ввести genre)
  
DELETE (Фильмы)
  1. Удаление фильмa по его id - api.films/films/id-1
  
DELETE (Актеры)
  1. Удаление актера по его id - api.films/actors/id-1

DELETE (Жанры)
  1. Удаление жанра по его id - api.films/genres/id-1
  
PATCH (Фильмы)
  1. Изменение данных идет через raw по id фильма - api.films/films/id-1 (нужно написать в json формате строку {"film":"Аватар1", "genre":"2"})
