document.addEventListener('DOMContentLoaded', function() {
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
    //alert(jsonData);
    //console.log(jsonData);
    var xmlReq = new XMLHttpRequest();
    xmlReq.addEventListener('load', function(event) {
      alert('DELETED!');
    });
    xmlReq.addEventListener('error', function(event) {
      alert('Oops! Something went wrong.');
    });
    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u20598425/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.setRequestHeader("Authorization", "Basic " + btoa('uxxxxxxxxx:password'));
    xmlReq.send(jsonData);
  });
});




document.addEventListener('DOMContentLoaded', function() {
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
  }else{
    data["Title_ID"] = titleId;
  }
  var jsonData = JSON.stringify(data);
  //console.log(jsonData);
  var xmlReq = new XMLHttpRequest();
  xmlReq.addEventListener('load', function(event) {
    var response = JSON.parse(this.responseText);
    if (response.status === 'success') {
      var data = response.data;
      var message = 'Title ID: ' + data.Title_ID +'\n' +
                    'Title Name: ' + data.Title_Name +'\n' +
                    'Content Rating: ' + data.Content_Rating_ID +'\n' +
                    'Review Rating: ' + data.Review_Rating +'\n' +
                    'Release Date: ' + data.Release_Date +'\n' +
                    'Plot Summary: ' + data.Plot_Summary +'\n' +
                    'Crew: ' + data.Crew +'\n' +
                    'Image: ' + data.Image +'\n' +
                    'Language: ' + data.Language_ID;
      alert(message);
    } else {
      alert('Oops! Something went wrong.');
    }
  });
  xmlReq.addEventListener('error', function(event) {
    alert('Oops! Something went wrong.');
  });
  xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u20598425/cos221/admindb.php", true);
  xmlReq.setRequestHeader("Content-Type", "application/json");
  xmlReq.setRequestHeader("Authorization", "Basic " + btoa('uxxxxxxxxx:password'));
  xmlReq.send(jsonData);
});
});

  document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('updateButton').addEventListener('click', function(event) {
      event.preventDefault();
      var data = {
          "type": "UpdateMovieOrSeries",
          "Title_ID": document.getElementById('updateTitleID').value
        };
        
        var fields = ['Title_Name', 'Content_Rating_ID', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Image', 'Language_ID'];
        fields.forEach(function(field) {
          var element = document.getElementById(field);
          if (element && element.value) {
            data[field] = element.value;
          }
        });
      var isMovieCheckbox = document.getElementById('updateType');
      if (isMovieCheckbox && isMovieCheckbox.checked) {
        data['isMovie'] = 1;
      } else {
        data['isMovie'] = 0;
      }
      var jsonData = JSON.stringify(data);
      //alert(jsonData);
      //console.log(jsonData);
  
      // Create a new XMLHttpRequest obj
      var xmlReq = new XMLHttpRequest();
  
      //def if successful data submission
      xmlReq.addEventListener('load', function(event) {
        alert('UPDATED!.');
      });
  
      // def if error
      xmlReq.addEventListener('error', function(event) {
        alert('Oops! Something went wrong.');
      });
  
      // Set request
      xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u20598425/cos221/admindb.php", true);
      xmlReq.setRequestHeader("Content-Type", "application/json");
      xmlReq.setRequestHeader("Authorization", "Basic " + btoa('uxxxxxxxxx:password'));
  
      // Send req
      xmlReq.send(jsonData);
    });
  });



window.onload = function() {
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
      "Language_ID": document.getElementById('languageIDaa').value,
    };
    for (var key in data) {
      if (data[key] === '') {
        alert(key + ' must not be empty');
        return; 
      }
    }
    var isMovieCheckbox = document.getElementById('typeadd');
    if (isMovieCheckbox && isMovieCheckbox.checked) {
      data['isMovie'] = 1;
    } else {
      data['isMovie'] = 0;
    }
    var jsonData = JSON.stringify(data);
    //alert(jsonData);
    //console.log(jsonData);  //in gelos vir testing 
  
    // maak a new XMLHttpRequest obj
    var xmlReq = new XMLHttpRequest();

    // def on successful data submission
    xmlReq.addEventListener('load', function(event) {
      alert(document.getElementById('titleNameaa').value + ' has been added to the database.');
    });

    //def if error
    xmlReq.addEventListener('error', function(event) {
      alert('Oops! Something went wrong.');
    });

    // set up request
    xmlReq.open("POST", "https://wheatley.cs.up.ac.za/u20598425/cos221/admindb.php", true);
    xmlReq.setRequestHeader("Content-Type", "application/json");
    xmlReq.setRequestHeader("Authorization", "Basic " + btoa('uxxxxxxxxx:password'));

    // Send request
    xmlReq.send(jsonData);
  });
}

function toggleSearchID() {
  var checkbox = document.getElementById('searchByTitleCheckbox');
  var titleIDInput = document.getElementById('searchTitleID');
  var titleIDLabel = document.getElementById('searchTitleIDLabel');
  var titleInput = document.getElementById('searchTitle');
  var titleLabel = document.getElementById('searchTitleLabel');
  if (checkbox.checked){
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
