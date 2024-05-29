<?php
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/stylesPA1.css">
</head>
<div id="flex-container">

  <div class="dropdown" id="filterbyGenre">
    <button class="dropbtn">Filter by Genre</button>
    <div class="dropdowncont">
      <span data-filter="genre" data-value="action" class="dropdown-item">action</span>
      <span data-filter="genre" data-value="animation" class="dropdown-item">animation</span>
      <span data-filter="genre" data-value="comedy" class="dropdown-item">comedy</span>
      <span data-filter="genre" data-value="crime" class="dropdown-item">crime</span>
      <span data-filter="genre" data-value="documentation" class="dropdown-item">documentation</span>
      <span data-filter="genre" data-value="drama" class="dropdown-item">drama</span>
      <span data-filter="genre" data-value="european" class="dropdown-item">european</span>
      <span data-filter="genre" data-value="family" class="dropdown-item">family</span>
      <span data-filter="genre" data-value="fantasy" class="dropdown-item">fantasy</span>
      <span data-filter="genre" data-value="history" class="dropdown-item">history</span>
      <span data-filter="genre" data-value="horror" class="dropdown-item">horror</span>
      <span data-filter="genre" data-value="music" class="dropdown-item">music</span>
      <span data-filter="genre" data-value="reality" class="dropdown-item">reality</span>
      <span data-filter="genre" data-value="romance" class="dropdown-item">romance</span>
      <span data-filter="genre" data-value="scifi" class="dropdown-item">scifi</span>
      <span data-filter="genre" data-value="sport" class="dropdown-item">sport</span>
      <span data-filter="genre" data-value="thriller" class="dropdown-item">thriller</span>
      <span data-filter="genre" data-value="war" class="dropdown-item">war</span>
      <span data-filter="genre" data-value="western" class="dropdown-item">western</span>
    </div>
  </div>
  <div class="dropdown" id="filterbyrating">
    <button class="dropbtn">Filter by rating</button>
    <div class="dropdowncont">
      <span data-filter="rating" data-value="1" class="dropdown-item">1</span>
      <span data-filter="rating" data-value="2" class="dropdown-item">2</span>
      <span data-filter="rating" data-value="3" class="dropdown-item">3</span>
      <span data-filter="rating" data-value="4" class="dropdown-item">4</span>
      <span data-filter="rating" data-value="5" class="dropdown-item">5</span>
      
    </div>
  </div>

  <div class="dropdown" id="filterlanguage">
    <button class="dropbtn">Filter by language</button>
    <div class="dropdowncont">
      <span data-filter="language" data-value="English" class="dropdown-item">English</span>
      <span data-filter="language" data-value="Spanish" class="dropdown-item">Spanish</span>
      <span data-filter="language" data-value="German" class="dropdown-item">German</span>
      <span data-filter="language" data-value="Afrikaans" class="dropdown-item">Afrikaans</span>
      <span data-filter="language" data-value="Arabic" class="dropdown-item">Arabic</span>
      <span data-filter="language" data-value="Portugese" class="dropdown-item">Portugese</span>
      <span data-filter="language" data-value="Dutch" class="dropdown-item">Dutch</span>
      <span data-filter="language" data-value="Zulu" class="dropdown-item">Zulu</span>
      <span data-filter="language" data-value="isiXhosa" class="dropdown-item">isiXhosa</span>
    </div>
  </div>
  <div class="dropdown" id="sortByDropdown">
    <button class="dropbtn">Sort by</button>
    <div class="dropdowncont">
      <span data-filter="sort" data-value="ReleaseDate" class="dropdown-item">Release Date</span>
      <span data-filter="sort" data-value="title" class="dropdown-item">Title</span>
      <span data-filter="sort" data-value="rating" class="dropdown-item">Rating</span>

    </div>
  </div>
  <div class="dropdown" id="cleardropdown">
    <button class="dropbtn">Clear filters</button>
  </div>
</div>

<div class="alllistings">
    <!-- Movie Listings will be dynamically added here -->
</div>


<script src="Series.js"></script>

</body>
</html>

<?php
include 'footer.php';
?>
