document.addEventListener('DOMContentLoaded', function() {
  // Remove Movie or Series
  document.getElementById('removeButton').addEventListener('click', function(event) {
    event.preventDefault();
    var checkbox = document.getElementById('deleteByTitleCheckbox');
    var titleId = document.getElementById('removeTitleID').value;
    var titleName = document.getElementById('removeTitle').value;
    var data = {
      "type": "DeleteMovieOrSeries"
    };
    if (checkbox.checked) {
      data["Title_Name"] = titleName;
    } else {
      data["Title_ID"] = titleId;
    }
    var jsonData = JSON.stringify(data);
    var xmlReq = new XMLHttpRequest();
    xmlReq.addEventListener('load', function() {
      alert('DELETED!');
    });
    xmlReq.addEventListener('error', function() {
      alert('Oops! Something went wrong.');
    });
    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(jsonData);
  });

  // Register Admin
  document.getElementById("registerButton").addEventListener("click", function(event) {
    event.preventDefault();
    const name = document.getElementById('fname').value;
    const surname = document.getElementById('lname').value;
    const email = document.getElementById('email').value;
    const dob = document.getElementById('dob').value;
    const password = document.getElementById('password').value;
    var registerMessage = document.getElementById("registerMessage");

    if (!name || !surname || !email || !dob || !password) {
      registerMessage.innerText = 'Please fill out all fields.';
      return;
    }

    var requestBody = {
      "type": "RegisterAdmin",
      "name": name,
      "surname": surname,
      "email": email,
      "password": password,
      "DOB": dob
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/api.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        var response = JSON.parse(xhr.responseText);
        if (xhr.status === 200 && response.status === "Success") {
          registerMessage.textContent = "Registration Success: " + response.message;
        } else {
          registerMessage.textContent = "Registration failed: " + response.message;
        }
      } else {
        registerMessage.textContent = "Registration request failed. HTTP status: " + xhr.status;
      }
    };
    xhr.send(JSON.stringify(requestBody));
  });

  // Search Movie or Series
  document.getElementById('searchButton').addEventListener('click', function(event) {
    event.preventDefault(); 
    var checkbox = document.getElementById('searchByTitleCheckbox');
    var titleId = document.getElementById('searchTitleID').value;
    var titleName = document.getElementById('searchTitle').value;
    var data = {
      "type": "GetDetails"
    };
    if (checkbox.checked) {
      data["Title_Name"] = titleName;
    } else {
      data["Title_ID"] = titleId;
    }
    var jsonData = JSON.stringify(data);
    var xmlReq = new XMLHttpRequest();
    xmlReq.addEventListener('load', function() {
      var response = JSON.parse(this.responseText);
      if (response.status === 'success') {
        var data = response.data;
        var message = 'Title ID: ' + data.title.Title_ID +'\n' +
                      'Title Name: ' + data.title.Title_Name +'\n' +
                      'Content Rating: ' + data.title.Content_Rating_ID +'\n' +
                      'Review Rating: ' + data.title.Review_Rating +'\n' +
                      'Release Date: ' + data.Release_Date +'\n' +
                      'Plot Summary: ' + data.title.Plot_Summary +'\n' +
                      'Image: ' + data.title.Image +'\n' +
                      'Language: ' + data.title.Language_ID;
        alert(message);
      } else {
        alert('Oops! Something went wrong.');
      }
    });
    xmlReq.addEventListener('error', function() {
      alert('Oops! Something went wrong.');
    });
    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(jsonData);
  });

  // Update Movie or Series
  document.getElementById('updateButton').addEventListener('click', function(event) {
    event.preventDefault();
    var data = {
      "type": "UpdateMovieOrSeries",
      "Title_ID": document.getElementById('updateTitleID').value
    };

    var fields = ['Title_Name', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Image', 'Language_ID'];
    fields.forEach(function(field) {
      var element = document.getElementById(field);
      if (element && element.value) {
        data[field] = element.value;
      }
    });

    var isMovieCheckbox = document.getElementById('updateType');
    data['isMovie'] = isMovieCheckbox && isMovieCheckbox.checked ? 1 : 0;

    var jsonData = JSON.stringify(data);
    var xmlReq = new XMLHttpRequest();

    xmlReq.addEventListener('load', function() {
      alert('UPDATED!.');
    });
    xmlReq.addEventListener('error', function() {
      alert('Oops! Something went wrong.');
    });

    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(jsonData);
  });

  // Add Movie or Series
  document.getElementById('addButton').addEventListener('click', function(event) {
    event.preventDefault();
    var data = {
      "type": "InsertMovieOrSeries",
      "Title_Name": document.getElementById('titleNameaa').value,
      "Content_Rating_ID": document.getElementById('contentRatingIDaa').value,
      "Review_Rating": document.getElementById('reviewRatingaa').value,
      "Release_Date": document.getElementById('releaseDateaa').value,
      "Plot_Summary": document.getElementById('plotSummaryaa').value,
      "Image": document.getElementById('imageaa').value,
      "Language_ID": document.getElementById('languageIDaa').value
    };

    for (var key in data) {
      if (data[key] === '') {
        alert(key + ' must not be empty');
        return; 
      }
    }

    var isMovieCheckbox = document.getElementById('typeadd');
    data['isMovie'] = isMovieCheckbox && isMovieCheckbox.checked ? 1 : 0;

    var jsonData = JSON.stringify(data);
    var xmlReq = new XMLHttpRequest();

    xmlReq.addEventListener('load', function() {
      alert(document.getElementById('titleNameaa').value + ' has been added to the database.');
    });
    xmlReq.addEventListener('error', function() {
      alert('Oops! Something went wrong.');
    });

    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u23536013/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.send(jsonData);
  });

  // Toggle Search by ID or Title
  document.getElementById('searchByTitleCheckbox').addEventListener('change', function() {
    toggleSearchID();
  });
});

function toggleSearchID() {
  var checkbox = document.getElementById('searchByTitleCheckbox');
  var titleIDInput = document.getElementById('searchTitleID');
  var titleIDLabel = document.getElementById('searchTitleIDLabel');
  var titleInput = document.getElementById('searchTitle');
  var titleLabel = document.getElementById('searchTitleLabel');

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
