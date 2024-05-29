document.addEventListener("DOMContentLoaded", function() {
    var loader = document.querySelector(".loader");
    var listingDetailsContainer = document.querySelector(".allinfo");

    var urlParams = new URLSearchParams(window.location.search);
    var titleId = urlParams.get('Title_ID');

    fetchListingDetails(titleId);

    function fetchListingDetails(titleId) {
        loader.style.display = "block";
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
    
        var requestBody = {
            "type": "GetDetails",
            "title_ID": parseInt(titleId)
        };
    
        xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u20598425/cos221/api.php", true); // replace "/api-endpoint" with your actual API endpoint
        xmlReq.setRequestHeader("Content-Type", "application/json");
        xmlReq.send(JSON.stringify(requestBody));
    }

    function populateListingDetails(title) {
        loader.style.display = "none";
        listingDetailsContainer.style.display = "flex";

        var detailsContainer = document.querySelector(".details");
        detailsContainer.innerHTML = `
            <h2>${title.Title_Name}</h2>
            <p>Content Rating: ${title.Content_Rating_ID}</p>
            <p>Release Date: ${title.Release_Date}</p>
            <p>Plot Summary: ${title.Plot_Summary}</p>
            <p>Language: ${title.Language_ID}</p>
            <img src="${title.Image}" alt="${title.Title_Name}">
        `;
    }
});
