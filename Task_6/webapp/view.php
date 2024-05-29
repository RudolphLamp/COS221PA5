<?php
include 'header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/view.css">
</head>


        
<div class="allinfo">
    <div class="details">
        <!-- Movie details will be populated here -->
    </div>

    <div id="review-section" style="display: none;">
        <h2>Write a Review</h2>
        <form id="review-form">
            <label for="review-text">Review:</label><br>
            <textarea id="review-text" name="review" rows="4" cols="50"></textarea><br><br>

            <label for="review-rating">Rating:</label><br>
            <select id="review-rating" name="rating">
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select><br><br>

            <button type="submit" id = "reviewbtn">Submit Review</button>
        </form>
    </div>

    <div id="previous-reviews" style="display: none;">
        <h2>Previous Reviews</h2>
        <div id="reviews-list">
            <!-- Previous reviews will be populated here -->
        </div>
    </div>
</div>



    <script src="View.js"></script>
</body>
</html>


<?php
include 'footer.php';
?>
