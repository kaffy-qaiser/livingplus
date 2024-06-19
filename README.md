# Living+


## Description

Living+ is a housing marketplace designed to help students find roommates and housing options near their university. It also provides a platform for users to review different housing options. Users can add reviews, like listings, create housing groups, and assess living options.

## Tech Stack

- **PHP**
- **JavaScript**
- **Docker**
- **Google Maps API**
- **MariaDB**

## Features

- **Roommate and Housing Search**: Easily find roommates and housing options near your university.
- **User Reviews**: Review and rate different housing options.
- **Likes and Favorites**: Like listings and save your favorite housing options.
- **Housing Groups**: Create and join housing groups to find the perfect living situation.
- **Living Options Assessment**: Assess various living options based on user reviews and other criteria.

## Getting Started

### Prerequisites

- Docker installed on your machine.
- A Google Maps API key.

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/kaffy-qaiser/livingplus.git
   ```
2. Navigate to the project directory:
   ```bash
   cd livingplus
   ```
3. Build and start the Docker containers:
   ```bash
   docker-compose up --build
   ```

### Configuration

1. Create a `.env` file in the root directory and add your Google Maps API key:
   ```plaintext
   GOOGLE_MAPS_API_KEY=your_google_maps_api_key
   ```

## Usage

1. Access the application in your web browser at `http://localhost:8000`.
2. Sign up or log in to start exploring housing options and connecting with potential roommates.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License.



