<h2>POST NEW JOKE</h2>
<form action="postJoke.proc.php" method="POST">
    <label for="author">Author:</label>
    <input type="text" name="author" id="author" required><br>

    <label for="joke">Joke:</label>
    <textarea name="joke"  id="joke" required></textarea><br>

    <label for="source">Source:</label>
    <input type="text" name="source" id="source" required ><br>

    <input type="submit" value="Crear">
</form>
