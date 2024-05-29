<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="admin.js"></script>
</head>
<body>

<!-- create form for add -->

<h2>Add Movies/Series</h2>
<form method="post">
  <label for="titleName">Title Name:</label><br>
  <input type="text" id="titleNameaa" name="titleNameaa"><br>
  <label for="contentRatingID">Content Rating ID:</label><br>
  <input type="number" id="contentRatingIDaa" name="contentRatingIDaa" min="1" step="1"><br>
  <label for="reviewRating">Review Rating:</label><br>
  <input type="number" id="reviewRatingaa" name="reviewRatingaa" min="1" max="5" step="1"><br>
  <label for="releaseDate">Release Year:</label><br>
  <input type="number" id="releaseDateaa" name="releaseDateaa" min="1800" max="2027" step="1"><br>
  <label for="plotSummary">Plot Summary:</label><br>
  <textarea id="plotSummaryaa" name="plotSummaryaa"></textarea><br>
  <label for="image">Image URL:</label><br>
  <input type="text" id="imageaa" name="imageaa"><br>
  <label for="languageID">Language ID:</label><br>
  <input type="number" id="languageIDaa" name="languageIDaa" min="1" step="1"><br>
  <input type="checkbox" id="typeadd" name="typeaa" value="series">
  <label for="type"> Check if it's a movie else don't if series</label><br>
  <input type="submit" id="addButton" value="Submit">
</form>


<!-- create form for update -->

<h2>Update Movies/Series</h2>
<form method="post">
  <label for="updateTitleID">Title ID:</label><br>
  <input type="number" id="updateTitleID" name="updateTitleID" min="1" step="1"><br>
  <label for="updateTitleName">Title Name:</label><br>
  <input type="text" id="Title_Name" name="Title_Name"><br>
  <label for="updateContentRatingID">Content Rating ID:</label><br>
  <input type="number" id="Content_Rating_ID" name="Content_Rating_ID" min="1" step="1"><br>
  <label for="updateReviewRating">Review Rating:</label><br>
  <input type="number" id="Review_Rating" name="Review_Rating" min="1" step="1"><br>
  <label for="updateReleaseDate">Release Year:</label><br>
  <input type="number" id="Release_Date" name="Release_Date" min="1800" max="2099" step="1"><br>
  <label for="updatePlotSummary">Plot Summary:</label><br>
  <textarea id="Plot_Summary" name="Plot_Summary"></textarea><br>
  <label for="updateImage">Image URL:</label><br>
  <input type="text" id="Image" name="Image"><br>
  <label for="updateLanguageID">Language ID:</label><br>
  <input type="number" id="Language_ID" name="Language_ID" min="1" step="1"><br>
  <input type="checkbox" id="updateType" name="updateType" value="series">
  <label for="updateType">Check if it's a movie else don't if series</label><br>
  <input type="submit" id="updateButton" value="Submit">
</form>

<!-- create form for kyk -->

<h2>Search Movies/Series</h2>
<form method="post">
  <input type="checkbox" id="searchByTitleCheckbox" onclick="toggleSearchID()">
  <label for="searchByTitleCheckbox">Search by Title</label><br>
  <label for="searchTitleID" id="searchTitleIDLabel">Title ID:</label><br>
  <input type="number" id="searchTitleID" name="searchTitleID" min="1" step="1"><br>
  <label for="searchTitle" id="searchTitleLabel" style="display: none;">Title:</label><br>
  <input type="text" id="searchTitle" name="searchTitle" style="display: none;"><br>
  <input type="submit" id="searchButton" value="Search">
</form>

<!-- create form for delete -->
<h2>Remove Movies/Series</h2>
<form method="post">
  <input type="checkbox" id="deleteByTitleCheckbox" onclick="toggleTitleID()">
  <label for="deleteByTitleCheckbox">Delete by Title</label><br>
  <label for="removeTitleID" id="removeTitleIDLabel">Title ID:</label><br>
  <input type="number" id="removeTitleID" name="removeTitleID" min="1" step="1"><br>
  <label for="removeTitle" id="removeTitleLabel" style="display: none;">Title:</label><br>
  <input type="text" id="removeTitle" name="removeTitle" style="display: none;"><br>
  <input type="submit" id="removeButton" value="Submit">
</form>


<div class="container">
      <div class="form">
        <h2> Signup</h2>
        <form id="signupUser">
          <label for="fname">First Name:</label><br />
          <input type="text" id="fname" fname="fname" /><br />
          <label for="lname">Last Name:</label><br />
          <input type="text" id="lname" lname="lname" /><br />
          <label for="email">Email:</label><br />
          <input type="email" id="email" name="email" /><br />
          <label for="dob">Date of Birth:</label><br />
          <input type="date" id="dob" name="dob" /><br />
          <label for="password">Password:</label><br />
          <input type="password" id="password" name="password" /><br /><br />
          <button type="submit" id = "registerButton">Signup</button>
        </form>
        <div id = "registerMessage">
          <!-- Register message here -->
        </div>
      </div>
  </div>

<script>
function toggleTitleID() {
  var checkbox = document.getElementById('deleteByTitleCheckbox');
  var titleIDInput = document.getElementById('removeTitleID');
  var titleIDLabel = document.getElementById('removeTitleIDLabel');
  var titleInput = document.getElementById('removeTitle');
  var titleLabel = document.getElementById('removeTitleLabel');

  if (checkbox.checked) {
    titleIDInput.style.display = 'none';
    titleIDLabel.style.display = 'none';
    titleInput.style.display = 'block';
    titleLabel.style.display = 'block';
  } else {
    titleIDInput.style.display = 'block';
    titleIDLabel.style.display = 'block';
    titleInput.style.display = 'none';
    titleLabel.style.display = 'none';
  }
}
</script>

</body>
</html>
