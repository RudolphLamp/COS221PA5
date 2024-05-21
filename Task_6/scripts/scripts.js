// Mock series data
const series = [
  {
    series_ID: 1,
    title: "Breaking Bad",
    image: "../resources/images/five-came-back-the-reference-films.webp",
    seasons: 3,
    episodes: 25,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
  {
    series_ID: 2,
    title: "Stranger Things",
    image: "http://www.talon.news/wp-content/uploads/2019/09/tdk.jpg",
    seasons: 2,
    episodes: 10,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
  {
    series_ID: 3,
    title: "Game of Thrones",
    image: "https://m.media-amazon.com/images/I/91JnoM0khKL._SL1500_.jpg",
    seasons: 8,
    episodes: 80,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
  {
    series_ID: 4,
    title: "The Crown",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl-jSs-HMqskd3HoX90ImSShYGVQpoUQgYXPO9APzmQA&s",
    seasons: 5,
    episodes: 42,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
  {
    series_ID: 5,
    title: "Money Heist",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStmNp3Ic12ilEx2iWJKsbyi7H3RUKYEmxyZNqSiFjTnA&s",
    seasons: 6,
    episodes: 60,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
  {
    series_ID: 6,
    title: "The Mandalorian",
    image:
      "https://egoamo.co.za/cdn/shop/products/Pulp_Fiction_800x.jpg?v=1573184419",
    seasons: 4,
    episodes: 30,
    director: "Vince Gilligan",
    cast: ["Bryan Cranston", "Aaron Paul", "Anna Gunn"],
    production_company: "Sony Pictures Television",
  },
];

// Display series on the webpage
const seriesSection = document.querySelector(".series");
series.forEach((serie) => {
  const serieDiv = document.createElement("div");
  serieDiv.classList.add("serie");

  // Create and append the title element
  const titleElement = document.createElement("h2");
  titleElement.textContent = serie.title;
  serieDiv.appendChild(titleElement);

  // Create and append the image element
  const serieImg = document.createElement("img");
  serieImg.src = serie.image;
  serieImg.alt = serie.title;
  serieDiv.appendChild(serieImg);

  // Append the serieDiv to the seriesSection
  seriesSection.appendChild(serieDiv);
});

// Mock movie data
const movies = [
  {
    movie_ID: 1,
    title: "Inception",
    image:
      "https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p7825626_p_v8_ae.jpg",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action", "Adventure", "Sci-Fi"],
    production_company: "Warner Bros.",
    content_rating: "PG-18",
    review_rating: 6.2,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
  {
    movie_ID: 2,
    title: "The Dark Knight",
    image: "http://www.talon.news/wp-content/uploads/2019/09/tdk.jpg",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action", "Adventure", "Sci-Fi"],
    production_company: "Warner Bros.",
    content_rating: "PG-16",
    review_rating: 7.0,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
  {
    movie_ID: 3,
    title: "Interstellar",
    image: "https://m.media-amazon.com/images/I/91JnoM0khKL._SL1500_.jpg",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action", "Adventure", "Sci-Fi"],
    production_company: "Warner Bros.",
    content_rating: "PG-16",
    review_rating: 4.5,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
  {
    movie_ID: 4,
    title: "The Matrix",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl-jSs-HMqskd3HoX90ImSShYGVQpoUQgYXPO9APzmQA&s",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action", "Adventure", "Sci-Fi"],
    production_company: "FOX",
    content_rating: "PG-13",
    review_rating: 6.2,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
  {
    movie_ID: 5,
    title: "Fight Club",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStmNp3Ic12ilEx2iWJKsbyi7H3RUKYEmxyZNqSiFjTnA&s",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action"],
    production_company: "Warner Bros.",
    content_rating: "PG-13",
    review_rating: 5.4,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
  {
    movie_ID: 6,
    title: "Pulp Fiction",
    image:
      "https://egoamo.co.za/cdn/shop/products/Pulp_Fiction_800x.jpg?v=1573184419",
    plot_summary:
      "A thief who enters the dreams of others to steal secrets from their subconscious.",
    genres: ["Action", "Comedy"],
    production_company: "Warner Bros.",
    content_rating: "PG-13",
    review_rating: 9.0,
    director: "Christopher Nolan",
    cast: ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
  },
];

// Display movies on the webpage
const moviesSection = document.querySelector(".movies");
movies.forEach((movie) => {
  const movieDiv = document.createElement("div");
  movieDiv.classList.add("movie");

  // Create and append the title element
  const titleElement = document.createElement("h2");
  titleElement.textContent = movie.title;
  movieDiv.appendChild(titleElement);

  // Create and append the image element
  const movieImg = document.createElement("img");
  movieImg.src = movie.image;
  movieImg.alt = movie.title;
  movieDiv.appendChild(movieImg);

  // Append the movieDiv to the moviesSection
  moviesSection.appendChild(movieDiv);
});

// Search function for movies
function searchMovies(query) {
  const filteredMovies = movies.filter((movie) =>
    movie.title.toLowerCase().includes(query.toLowerCase())
  );
  displayMovies(filteredMovies);
}

// Filter function for movies
function filterMovies(genre) {
  const filteredMovies = movies.filter((movie) => movie.genres.includes(genre));
  displayMovies(filteredMovies);
}

// Sort function for movies
function sortMoviesByRating() {
  const sortedMovies = movies
    .slice()
    .sort((a, b) => b.review_rating - a.review_rating);
  displayMovies(sortedMovies);
}

// Function to display filtered/sorted movies
function displayMovies(moviesData) {
  const moviesSection = document.querySelector(".movies");
  moviesSection.innerHTML = "";
  moviesData.forEach((movie) => {
    const movieDiv = document.createElement("div");
    movieDiv.classList.add("movie");
    const titleElement = document.createElement("h2");
    titleElement.textContent = movie.title;
    movieDiv.appendChild(titleElement);
    const movieImg = document.createElement("img");
    movieImg.src = movie.image;
    movieImg.alt = movie.title;
    movieDiv.appendChild(movieImg);
    moviesSection.appendChild(movieDiv);
  });
}

// Search function for series
function searchSeries(query) {
  const filteredSeries = series.filter((serie) =>
    serie.title.toLowerCase().includes(query.toLowerCase())
  );
  displaySeries(filteredSeries);
}

// Filter function for series
function filterSeries(director) {
  const filteredSeries = series.filter((serie) => serie.director === director);
  displaySeries(filteredSeries);
}

// Function to display filtered series
function displaySeries(seriesData) {
  const seriesSection = document.querySelector(".series");
  seriesSection.innerHTML = "";
  seriesData.forEach((serie) => {
    const serieDiv = document.createElement("div");
    serieDiv.classList.add("serie");
    const titleElement = document.createElement("h2");
    titleElement.textContent = serie.title;
    serieDiv.appendChild(titleElement);
    const serieImg = document.createElement("img");
    serieImg.src = serie.image;
    serieImg.alt = serie.title;
    serieDiv.appendChild(serieImg);
    seriesSection.appendChild(serieDiv);
  });
}

//Function to sort by season(kinda similar to sort by rating)

// Function to add new movie

// Function to add new series

// Initial display of movies and series
displayMovies(movies);
displaySeries(series);
