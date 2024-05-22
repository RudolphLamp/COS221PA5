<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

<h2>Add Movies/Series</h2>
<form action="add_movie_series.php" method="post">
  <label for="titleName">Title Name:</label><br>
  <input type="text" id="titleName" name="titleName"><br>

  <label for="contentRatingID">Content Rating ID:</label><br>
  <input type="number" id="contentRatingID" name="contentRatingID" min="1" step="1"><br>

  <label for="reviewRating">Review Rating:</label><br>
  <input type="number" id="reviewRating" name="reviewRating" min="1" step="0.1"><br>

  <label for="releaseDate">Release Year:</label><br>
  <input type="number" id="releaseDate" name="releaseDate" min="1800" max="2099" step="1"><br>

  <label for="plotSummary">Plot Summary:</label><br>
  <textarea id="plotSummary" name="plotSummary"></textarea><br>

  <label for="image">Image URL:</label><br>
  <input type="text" id="image" name="image"><br>

  <label for="languageID">Language ID:</label><br>
  <input type="number" id="languageID" name="languageID" min="1" step="1"><br>

  <input type="checkbox" id="type" name="type" value="series">
  <label for="type"> Check if it's a series</label><br>

  <input type="submit" value="Submit">
</form>

<h2>Update Movies/Series</h2>
<form action="update_movie_series.php" method="post">
  <label for="titleID">Title ID:</label><br>
  <input type="number" id="titleID" name="titleID" min="1" step="1"><br>

  <label for="titleName">Title Name:</label><br>
  <input type="text" id="titleName" name="titleName"><br>

  <label for="contentRatingID">Content Rating ID:</label><br>
  <input type="number" id="contentRatingID" name="contentRatingID" min="1" step="1"><br>

  <label for="reviewRating">Review Rating:</label><br>
  <input type="number" id="reviewRating" name="reviewRating" min="1" step="0.1"><br>

  <label for="releaseDate">Release Year:</label><br>
  <input type="number" id="releaseDate" name="releaseDate" min="1800" max="2099" step="1"><br>

  <label for="plotSummary">Plot Summary:</label><br>
  <textarea id="plotSummary" name="plotSummary"></textarea><br>

  <label for="image">Image URL:</label><br>
  <input type="text" id="image" name="image"><br>

  <label for="languageID">Language ID:</label><br>
  <input type="number" id="languageID" name="languageID" min="1" step="1"><br>

  <input type="checkbox" id="type" name="type" value="series">
  <label for="type"> Check if it's a series</label><br>

  <input type="submit" value="Submit">
</form>

<h2>Remove Movies/Series</h2>
<form action="remove_movie_series.php" method="post">
  <label for="titleID">Title ID:</label><br>
  <input type="number" id="titleID" name="titleID" min="1" step="1"><br>
  <input type="submit" value="Submit">
</form>

</body>
</html>
