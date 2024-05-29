document.addEventListener("DOMContentLoaded", function() {
    const isChildProfile = getCookie('isChild');
    var listingDetailsContainer = document.querySelector(".allinfo");

    var urlParams = new URLSearchParams(window.location.search);
    var titleId = urlParams.get('Title_ID');

    if (isChildProfile == 0) {
            document.getElementById("review-section").style.display = "block";
            document.getElementById("previous-reviews").style.display = "block";
        

        fetchReviews();

        var loginbtn =document.getElementById("reviewbtn");
        // Handle review form submission
        loginbtn.addEventListener("click", function(event) {
            event.preventDefault();
            submitReview();
            fetchReviews(); // Refresh reviews list
        });
    }
    fetchListingDetails(titleId);
});

function fetchListingDetails(titleId) {
    var listingDetailsContainer = document.querySelector(".allinfo");
    listingDetailsContainer.style.display = "none";

    var xmlReq = new XMLHttpRequest();
    xmlReq.onreadystatechange = function() {
        if (xmlReq.readyState === XMLHttpRequest.DONE) {
            if (xmlReq.status === 200) {
                var response = JSON.parse(xmlReq.responseText);
                if (response.status === "Success") {
                    var title = response.data;
                    populateListingDetails(title);
                } else {
                    console.error("Error fetching title details:", response.message);
                }
            } else {
                console.error("Error fetching title details. HTTP status:", xmlReq.status);
            }
        }
    };
    var profileid = getCookie("Profile_ID");

    var requestBody = {
        "type": "GetDetails",
        "title_ID": titleId ,
        "Profile_ID": profileid
    };

    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/api.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(JSON.stringify(requestBody));
}

function populateListingDetails(title) {
    var listingDetailsContainer = document.querySelector(".allinfo");
    listingDetailsContainer.style.display = "flex";

    var detailsContainer = document.querySelector(".details");
    detailsContainer.innerHTML = `
        <img src="${title.Image}" alt="${title.Title_Name}">
        <h2>${title.Title_Name}</h2>
        <p>Content Rating: ${title.Content_Rating_ID}</p>
        <p>Release Date: ${title.Release_Date}</p>
        <p>Plot Summary: ${title.Plot_Summary}</p>
        <p>Language: ${title.Language_ID}</p>
    `;
}

function fetchReviews() {
    var xmlReq = new XMLHttpRequest();
    xmlReq.onreadystatechange = function() {
        if (xmlReq.readyState === XMLHttpRequest.DONE) {
            if (xmlReq.status === 200) {
                var response = JSON.parse(xmlReq.responseText);
                if (response.status === "Success") {
                    var reviews = response.data;
                    var reviewsList = document.getElementById("reviews-list");
                    reviewsList.innerHTML = ''; // Clear existing reviews

                    reviews.forEach(review => {
                        var reviewElement = document.createElement("div");
                        reviewElement.classList.add("review");
                        reviewElement.innerHTML = `
                            <p style="color: white"><strong>Rating:</strong> ${review.Rating} Stars</p>
                            <p style="color: white"><strong>Review:</strong> ${review.Review_Content}</p>
                            <hr>
                        `;
                        reviewsList.appendChild(reviewElement);
                    });
                } else {
                    console.error("Error fetching reviews:", response.message);
                }
            } else {
                console.error("Error fetching reviews. HTTP status:", xmlReq.status);
            }
        }
    };

    var urlParams = new URLSearchParams(window.location.search);
    var titleId = urlParams.get('Title_ID');

        var requestBody = {
            "type": "GetReviews",
            "title_ID": titleId
        };

    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/api.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(JSON.stringify(requestBody));
}

function submitReview() {
    var xmlReq = new XMLHttpRequest();
    xmlReq.onreadystatechange = function() {
        if (xmlReq.readyState === XMLHttpRequest.DONE) {
            if (xmlReq.status === 200) {
                var response = JSON.parse(xmlReq.responseText);
                if (response.status === "Review submitted successfully") {
                    alert("Review submitted successfully!");
                } else {
                    alert("Failed to submit review: " + response.message);
                }
            } else {
                alert("Failed to submit review. HTTP status: " + xmlReq.status);
            }
        }
    };

    var reviewText = document.getElementById("review-text").value;
    var reviewRating = document.getElementById("review-rating").value;
    var urlParams = new URLSearchParams(window.location.search);
    var titleId = urlParams.get('Title_ID');
    var profileId = getCookie("Profile_ID");

    var requestBody = {
        "type": "SubmitReview",
        "title_ID": titleId,
        "profile_ID": profileId,
        "review_text": reviewText,
        "rating": reviewRating
    };

    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/api.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(JSON.stringify(requestBody));
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
    }
    return null;
}


