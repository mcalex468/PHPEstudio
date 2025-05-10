<?php
$db = new SQLite3('storebooks.db');

// Crear la tabla (eliminar si ya existe)
$db->exec("DROP TABLE IF EXISTS llibres");
$db->exec("CREATE TABLE llibres (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titol TEXT,
    autor TEXT,
    any INTEGER,
    categoria TEXT,
    isbn TEXT,
    'rating.rate' REAL,
    'rating.count' INTEGER
)");

// Insertar múltiples libros agrupados en solo 4 categorías
$db->exec("
    INSERT INTO llibres (titol, autor, any, categoria, isbn, 'rating.rate', 'rating.count') VALUES
    -- Ficción
    ('Cien años de soledad', 'Gabriel García Márquez', 1967, 'Ficción', '9788497592208', 4.8, 950),
    ('1984', 'George Orwell', 1949, 'Ficción', '9780451524935', 4.6, 1200),
    ('Fahrenheit 451', 'Ray Bradbury', 1953, 'Ficción', '9781451673319', 4.4, 700),

    -- Clásico
    ('Don Quijote de la Mancha', 'Miguel de Cervantes', 1605, 'Clásico', '9780142437230', 4.7, 800),
    ('Orgullo y prejuicio', 'Jane Austen', 1813, 'Clásico', '9780141439518', 4.5, 600),
    ('Rayuela', 'Julio Cortázar', 1963, 'Clásico', '9788437601896', 4.2, 450),

    -- Infantil
    ('El principito', 'Antoine de Saint-Exupéry', 1943, 'Infantil', '9780156012195', 4.9, 1500),
    ('Matilda', 'Roald Dahl', 1988, 'Infantil', '9780142410370', 4.7, 1300),
    ('Charlie y la fábrica de chocolate', 'Roald Dahl', 1964, 'Infantil', '9780142410318', 4.6, 1000),

    -- Misterio
    ('La sombra del viento', 'Carlos Ruiz Zafón', 2001, 'Misterio', '9788408172170', 4.8, 1100),
    ('El nombre de la rosa', 'Umberto Eco', 1980, 'Misterio', '9788422648435', 4.4, 750),
    ('Crónica de una muerte anunciada', 'Gabriel García Márquez', 1981, 'Misterio', '9788497592437', 4.3, 500)
");

echo "📚 Base de datos creada con 12 libros y 4 categorías.\n";
?>
