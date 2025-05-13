# README
# ACTIVIDADES ESTUDIO EXAMEN PHP API's

# USO API

# CURL

# CREACIÓ API

# 📚 API REST per a Gestió de Llibres (PHP + SQLite)

## 🚦 3. MANEIG DE MÈTODES HTTP

### GET
- `/llibres` → Obtenir tots els llibres
- `/llibres?categoria=X` → Obtenir llibres per categoria
- `/llibres?id=3` → Obtenir llibre per ID
- `/llibres?categoria=all` → Obtenir totes les categories úniques

### POST
- Insereix un nou llibre
- Llegeix `php://input`, decodifica el JSON
- Prepara i executa `INSERT INTO llibres (...) VALUES (...)`
- Valida que tots els camps requerits siguin presents

### PUT
- Actualitza completament un llibre
- Requereix **tots els camps** i l'`id`

### PATCH
- Actualitza **només alguns camps** d’un llibre
- Genera dinàmicament els camps `SET` per a l’`UPDATE`
- Només requereix l'`id` i els camps modificables

### DELETE
- Elimina un llibre per `id`
- L'`id` pot venir per `$_GET['id']` o pel cos de la petició (`php://input`)

---

## 💡 4. TIPS PRÀCTICS

### 🔍 Seguretat i validació
- Utilitza **`prepare()`** i **`bindValue()`** SEMPRE per evitar **injeccions SQL**
- Valida que els camps requerits existeixin abans d'operar

### 🧪 Proves ràpides
- Fes servir **Postman** o **Insomnia** per provar els mètodes `POST`, `PUT`, `PATCH`, `DELETE`
- Si no pots utilitzar eines externes, crea petits formularis HTML o peticions `fetch` amb JavaScript

### 🧹 Neteja del JSON
- Envia sempre `Content-Type: application/json` des de JS
- Usa:  
  ```php
  json_decode(file_get_contents('php://input'), true);
