const profile_picture= "../resources/images/profile_icon.webp";
// Mock current user_account
let currentUser = {
    User_ID : 1,
    First_Name: "John Doe",
    Last_Name: "Doe",
    Date_of_Birth: "1990-05-15",
    Admin_privileges: 0,
    Email_Address: "john.doe@example.com",
};

// Mock user profiles
let otherProfiles = [
    {
        Profile_ID: 1,
        Profile_Name: "JohnDoe",
        User_ID: "user1",
        Child_Profile: 0,
    },
    {
        Profile_ID: 33,
        Profile_Name: "JohnJohn",
        User_ID: "user1",
        Child_Profile: 1,
    }
];

// Function to render profiles
function renderProfiles() {
    const profileList = document.getElementById("profileList");
    profileList.innerHTML = "";
    
    otherProfiles.forEach(profile => {
        const profileItem = document.createElement("div");
        profileItem.classList.add("profile-item");
        profileItem.innerHTML = `
            <img src="${profile_picture}" alt="Profile Picture">
            <div class="profile-details">
                <h2>${profile.Profile_Name}</h2>
                ${profile.Child_Profile ? "<p>Child Profile</p>" : "<p>Adult Profile</p>"}
                <button class="edit-profile-btn" onclick="editProfile(${profile.Profile_ID})">Edit</button>
                    <button class="delete-profile-btn" onclick="deleteProfile(${profile.Profile_ID})">Delete</button>
            </div>
        `;
        profileList.appendChild(profileItem);
    });
}


// Function to add a new profile
function addProfile() {
    // Mocking form inputs for profile details
    const profileName = prompt("Enter profile name:");
    const isChildProfile = confirm("Is this a child profile?");

    // Generating a unique Profile_ID for the new profile
    const newProfileID = otherProfiles.length + 1;

    // Creating the new profile object
    const newProfile = {
        Profile_ID: newProfileID,
        Profile_Name: profileName,
        User_ID: currentUser.User_ID,
        Child_Profile: isChildProfile ? 1 : 0,
    };

    // Adding the new profile to the otherProfiles array
    otherProfiles.push(newProfile);

    // Calling renderProfiles to update the displayed profiles
    renderProfiles();
}


// Function to edit a profile
function editProfile(profileID) {
    const profileIndex = otherProfiles.findIndex(profile => profile.Profile_ID === profileID);
    if (profileIndex !== -1) {
        const newProfileName = prompt("Enter new profile name:", otherProfiles[profileIndex].Profile_Name);
        const isChildProfile = confirm("Is this a child profile?");
        
        // Update the profile details
        otherProfiles[profileIndex].Profile_Name = newProfileName;
        otherProfiles[profileIndex].Child_Profile = isChildProfile ? 1 : 0;

        // Update the UI after deletion
        renderProfiles();
    }
}

// Function to delete a profile
function deleteProfile(profileID) {
    const confirmDelete = confirm("Are you sure you want to delete this profile?");
    if (confirmDelete) {
        // Find the index of the profile to be deleted
        const profileIndex = otherProfiles.findIndex(profile => profile.Profile_ID === profileID);
        
        // If profile exists, remove it from the array
        if (profileIndex !== -1) {
            otherProfiles.splice(profileIndex, 1);
            
            // Update the UI after deletion
            renderProfiles();
        }
    }
}


// Initial rendering of profiles
renderProfiles();

// Event listener for addProfileBtn
document.getElementById("addProfileBtn").addEventListener("click", addProfile);
